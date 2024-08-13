<?php
require 'BitrixAPI.php'; // Подключаем класс BitrixAPI

// Получаем список сделок из API и сохраняем их в базу данных
$deals = BitrixAPI::getDeals();
BitrixAPI::saveDealsToDB($deals);

// Получаем список сделок и связанных контактов из базы данных
$dealsFromDB = BitrixAPI::getDealsFromDB();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список сделок</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .deal-table th, .deal-table td {
            text-align: center;
        }
        .deal-table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Список сделок</h1>

        <?php if (!empty($dealsFromDB)): ?>
            <table class="table table-striped table-bordered deal-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>ЖК</th>
                        <th>Тип</th>
                        <th>Контакт</th>
                        <th>Телефон</th>
                        <th>Сумма</th>
                        <th>Дата начала</th>
                        <th>Дата закрытия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dealsFromDB as $deal): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($deal['id']); ?></td>
                            <td><?php echo htmlspecialchars($deal['title']); ?></td>
                            <td><?php echo htmlspecialchars($deal['jk']); ?></td>
                            <td><?php echo htmlspecialchars($deal['type_id']); ?></td>
                            <td><?php echo htmlspecialchars($deal['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($deal['phone']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($deal['opportunity'], 2, ',', ' ')); ?></td>
                            <td><?php echo htmlspecialchars(date('d.m.Y H:i:s', strtotime($deal['begindate']))); ?></td>
                            <td><?php echo htmlspecialchars(date('d.m.Y H:i:s', strtotime($deal['closedate']))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Сделки не найдены.</p>
        <?php endif; ?>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
