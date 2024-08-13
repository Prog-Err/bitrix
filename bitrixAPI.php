<?php

class BitrixAPI {
    // URL API и данные для подключения к базе данных
    private static $apiUrl = "https://bx.talan.group:8082/rest/8807/6hx8b92ygaopc5no";
    private static $dbHost = "localhost";
    private static $dbUser = "root";
    private static $dbPassword = "";
    private static $dbName = "bitrix";

    // Метод для получения сделок через API
    public static function getDeals() {
        $url = self::$apiUrl . '/crm.deal.list.json';
        $response = file_get_contents($url);
        $deals = json_decode($response, true);

        if (isset($deals['result'])) {
            return $deals['result'];
        } else {
            return [];
        }
    }

    // Метод для получения контактов через API
    public static function getContacts($contactId) {
        $url = self::$apiUrl . '/crm.contact.get.json?ID=' . $contactId;
        $response = file_get_contents($url);
        $contact = json_decode($response, true);

        if (isset($contact['result'])) {
            return $contact['result'];
        } else {
            return [];
        }
    }

    // Метод для сохранения сделок и контактов в базу данных
    public static function saveDealsToDB($deals) {
        // Подключение к БД
        $conn = new mysqli(self::$dbHost, self::$dbUser, self::$dbPassword, self::$dbName);
        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        // Сохраняем данные о сделках и связанных контактах
        foreach ($deals as $deal) {
            $jk = '';
            $contactId = $deal['CONTACT_ID'] ?? 0;
            $title = $deal['TITLE'] ?? "";
            $opportunity = $deal['OPPORTUNITY'] ?? 0.00;
            $type_id = $deal['TYPE_ID'] ?? "";
            $begindate = $deal['BEGINDATE'] ?? "";
            $closedate = $deal['CLOSEDATE'] ?? "";

            // Подготовка запроса для вставки или обновления данных сделки
            $stmt = $conn->prepare("
                INSERT INTO deals (id, title, jk,type_id, contact_id, opportunity, begindate, closedate)
                VALUES (?, ?, ?,?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    title=VALUES(title),
                    jk=VALUES(jk),
                    type_id=VALUES(type_id),
                    contact_id=VALUES(contact_id),
                    opportunity=VALUES(opportunity),
                    begindate=VALUES(begindate),
                    closedate=VALUES(closedate)
            ");
            $stmt->bind_param("isssiiss", $deal['ID'], $title, $jk, $type_id,$contactId, $opportunity, $begindate, $closedate);
            $stmt->execute();

            // Получаем данные контакта
            if ($contactId) {
                $contact = self::getContacts($contactId);
                $name = $contact['NAME'] ?? "";
                $second_name = $contact['SECOND_NAME'] ?? "";
                $last_name = $contact['LAST_NAME'] ?? "";
                $fullName = "$last_name $name $second_name";

                $phone = $contact['PHONE'][0]['VALUE'] ?? '';

                $stmt = $conn->prepare("
                    INSERT INTO contacts (id, full_name, phone)
                    VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                        full_name=VALUES(full_name),
                        phone=VALUES(phone)
                ");
                $stmt->bind_param("iss", $contact['ID'], $fullName, $phone);
                $stmt->execute();
            }
        }

        $conn->close();
    }

    // Метод для получения сделок из базы данных
    public static function getDealsFromDB() {
        // Подключение к БД
        $conn = new mysqli(self::$dbHost, self::$dbUser, self::$dbPassword, self::$dbName);
        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        // Получение сделок и связанных контактов
        $result = $conn->query("
            SELECT deals.id, deals.title, deals.jk, deals.opportunity, deals.begindate, deals.closedate, deals.type_id,
                   contacts.full_name, contacts.phone
            FROM deals
            LEFT JOIN contacts ON deals.contact_id = contacts.id
        ");

        $deals = [];
        while ($row = $result->fetch_assoc()) {
            $deals[] = $row;
        }

        $conn->close();

        return $deals;
    }
}
