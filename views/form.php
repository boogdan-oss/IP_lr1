<?php
$zavtra = date('Y-m-d', strtotime('+1 day'));
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Замовлення обладнання</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<h1>Замовлення звукового/світлового обладнання</h1>

<form action="/../src/submisiion.php" method="POST">

    <p>
        <label>Замовник (ПІБ):</label><br>
        <input type="text" name="zamovnyk" required>
    </p>

    <p>
        <label>Кількість комплектів (від 1 до 20):</label><br>
        <input type="number" name="kilkist" min="1" max="20" required>
    </p>

    <p>
        <label>Тип комплекту:</label><br>
        <select name="tip" required>
            <option value="">-- оберіть --</option>
            <option value="sound">Звук (sound) - 900 грн/комплект</option>
            <option value="light">Світло (light) - 700 грн/комплект</option>
            <option value="stage">Сцена (stage) - 1500 грн/комплект + монтаж</option>
        </select>
    </p>

    <p>
        <label>Дата події (не раніше завтра):</label><br>
        <input type="date" name="data_podiyi" min="<?php echo $zavtra; ?>" required>
    </p>

    <p>
        <label>Опис події (від 10 до 600 символів):</label><br>
        <textarea name="opys" rows="5" cols="40" minlength="10" maxlength="600" required></textarea>
    </p>

    <p>
        <button type="submit">Відправити замовлення</button>
    </p>

</form>

<p><a href="/../views/history.php">Переглянути історію замовлень</a></p>

</body>
</html>
