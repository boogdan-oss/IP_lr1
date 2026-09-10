<?php

require_once __DIR__ . '/../src/storage.php';

$vsi_zamovlennya = zavantazhyty_vsi_zamovlennya();


$filtr_tip = isset($_GET['tip']) ? $_GET['tip'] : '';


$do_pokazu = array();
foreach ($vsi_zamovlennya as $zamovlennya) {
    if ($filtr_tip == '' || $zamovlennya['tip'] == $filtr_tip) {
        $do_pokazu[] = $zamovlennya;
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Історія замовлень</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<h1>Історія замовлень</h1>

<p>Фільтр по типу комплекту:</p>
<p>
    <a href="history.php">Всі</a> |
    <a href="history.php?tip=sound">sound</a> |
    <a href="history.php?tip=light">light</a> |
    <a href="history.php?tip=stage">stage</a>
</p>

<?php if (count($do_pokazu) == 0) { ?>

    <p>Замовлень поки немає.</p>

<?php } else { ?>

    <table border="1" cellpadding="6">
        <tr>
            <th>Замовник</th>
            <th>Тип</th>
            <th>Кількість</th>
            <th>Дата події</th>
            <th>Вартість</th>
            <th>Коли створено</th>
        </tr>
        <?php foreach ($do_pokazu as $z) { ?>
            <tr>
                <td><?php echo htmlspecialchars($z['zamovnyk']); ?></td>
                <td><?php echo htmlspecialchars($z['tip']); ?></td>
                <td><?php echo htmlspecialchars($z['kilkist']); ?></td>
                <td><?php echo htmlspecialchars($z['data_podiyi']); ?></td>
                <td><?php echo htmlspecialchars($z['vartist']); ?> грн</td>
                <td><?php echo htmlspecialchars($z['data_stvorennya']); ?></td>
            </tr>
        <?php } ?>
    </table>

<?php } ?>

<p><a href="/../views/form.php">Повернутись до форми</a></p>

</body>
</html>
