<?php

require_once __DIR__ . '/../src/submisiion.php';

$orders = isset($orders) ? $orders : array();
$filterType = isset($filterType) ? $filterType : '';
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Історія заявок — Варіант 58</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<main class="container">
    <h1>Історія заявок</h1>

    <p>Фільтр за типом комплекту:</p>
    <div class="filter-menu">
        <a href="/?page=history" class="<?= $filterType === '' ? 'active' : '' ?>">Всі</a>
        <a href="/?page=history&amp;type=sound" class="<?= $filterType === 'sound' ? 'active' : '' ?>">sound</a>
        <a href="/?page=history&amp;type=light" class="<?= $filterType === 'light' ? 'active' : '' ?>">light</a>
        <a href="/?page=history&amp;type=stage" class="<?= $filterType === 'stage' ? 'active' : '' ?>">stage</a>
    </div>

    <?php if (count($orders) === 0): ?>
        <p>Заявок не знайдено.</p>
    <?php else: ?>
        <table class="history-table">
            <tr>
                <th>Замовник</th>
                <th>Тип</th>
                <th>Комплектів</th>
                <th>Дата події</th>
                <th>Опис</th>
                <th>Вартість</th>
                <th>Створено</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= e($order['customer']) ?></td>
                    <td><?= e($order['type']) ?></td>
                    <td><?= e($order['sets']) ?></td>
                    <td><?= e($order['date']) ?></td>
                    <td><?= e($order['description']) ?></td>
                    <td><?= e($order['total']) ?> грн</td>
                    <td><?= e($order['createdAt']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <p class="nav-link"><a href="/">Повернутись до форми</a></p>
</main>
</body>
</html>
