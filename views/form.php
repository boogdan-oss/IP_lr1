<?php
require_once __DIR__ . '/../src/submisiion.php';
$old = isset($old) ? $old : array(
        'customer' => '',
        'sets' => '',
        'type' => '',
        'date' => '',
        'description' => ''
);
$errors = isset($errors) ? $errors : array();
$result = isset($result) ? $result : null;
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Оренда обладнання для події — Варіант 58</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<main class="container">
    <h1>Оренда обладнання для події</h1>

    <?php if ($result !== null): ?>
        <p class="success-message">Заявку успішно зареєстровано!</p>

        <table class="result-table">
            <tr>
                <td>Ставка за комплект</td>
                <td><?= e($result['rate']) ?> грн</td>
            </tr>
            <tr>
                <td>Базова вартість (кількість × ставка)</td>
                <td><?= e($result['base']) ?> грн</td>
            </tr>
            <tr>
                <td>Знижка</td>
                <td><?= e($result['discountPercent']) ?>% — мінус <?= e($result['discountSum']) ?> грн</td>
            </tr>
            <tr>
                <td>Монтаж сцени (одноразово)</td>
                <td><?= e($result['assembly']) ?> грн</td>
            </tr>
            <tr class="total-row">
                <td>Разом до сплати</td>
                <td><?= e($result['total']) ?> грн</td>
            </tr>
        </table>
    <?php endif; ?>

    <form method="post" action="/">
        <div class="form-group">
            <label for="customer">Замовник:</label>
            <input type="text" id="customer" name="customer" value="<?= e($old['customer']) ?>">
            <?php if (isset($errors['customer'])): ?>
                <span class="error"><?= e($errors['customer']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="sets">Кількість комплектів (1–20):</label>
            <input type="number" id="sets" name="sets" min="1" max="20" value="<?= e($old['sets']) ?>">
            <?php if (isset($errors['sets'])): ?>
                <span class="error"><?= e($errors['sets']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="type">Тип комплекту:</label>
            <select id="type" name="type">
                <option value="">-- Оберіть тип --</option>
                <option value="sound" <?= $old['type'] === 'sound' ? 'selected' : '' ?>>Звук (sound) — 900 грн/комплект</option>
                <option value="light" <?= $old['type'] === 'light' ? 'selected' : '' ?>>Світло (light) — 700 грн/комплект</option>
                <option value="stage" <?= $old['type'] === 'stage' ? 'selected' : '' ?>>Сцена (stage) — 1500 грн/комплект + монтаж 800 грн</option>
            </select>
            <?php if (isset($errors['type'])): ?>
                <span class="error"><?= e($errors['type']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="date">Дата події (не раніше завтра):</label>
            <input type="date" id="date" name="date" value="<?= e($old['date']) ?>">
            <?php if (isset($errors['date'])): ?>
                <span class="error"><?= e($errors['date']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="description">Опис події (10–600 байтів):</label>
            <textarea id="description" name="description"><?= e($old['description']) ?></textarea>
            <?php if (isset($errors['description'])): ?>
                <span class="error"><?= e($errors['description']) ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Відправити заявку</button>
    </form>

    <p class="nav-link"><a href="/?page=history">Переглянути історію заявок</a></p>
</main>
</body>
</html>
