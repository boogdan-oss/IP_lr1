<?php


require_once __DIR__ . '/SubmissionProcessor.php';

$processor = new SubmissionProcessor();
$uspih = false;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uspih = $processor->obrobyty($_POST);
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Результат замовлення</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<h1>Результат замовлення</h1>

<?php if ($_SERVER['REQUEST_METHOD'] != 'POST') { ?>

    <p>Ця сторінка приймає дані тільки через форму.</p>
    <p><a href="/../views/form.php">Повернутись до форми</a></p>

<?php } elseif (count($processor->pomylky) > 0) { ?>

    <p style="color:red;">Знайдено помилки у формі:</p>
    <ul>
        <?php foreach ($processor->pomylky as $pomylka) { ?>
            <li style="color:red;"><?php echo htmlspecialchars($pomylka); ?></li>
        <?php } ?>
    </ul>
    <p><a href="/../views/form.php">Повернутись і виправити</a></p>

<?php } else { ?>

    <p style="color:green;">Замовлення прийнято!</p>

    <table border="1" cellpadding="6">
        <tr><td>Замовник</td><td><?php echo htmlspecialchars($processor->zamovnyk); ?></td></tr>
        <tr><td>Тип комплекту</td><td><?php echo htmlspecialchars($processor->tip); ?></td></tr>
        <tr><td>Кількість комплектів</td><td><?php echo htmlspecialchars($processor->kilkist); ?></td></tr>
        <tr><td>Дата події</td><td><?php echo htmlspecialchars($processor->data_podiyi); ?></td></tr>
        <tr><td>Опис</td><td><?php echo nl2br(htmlspecialchars($processor->opys)); ?></td></tr>
    </table>

    <h2>Розрахунок вартості</h2>
    <?php $r = $processor->rezultat_rozrahunku; ?>
    <table border="1" cellpadding="6">
        <tr><td>Ставка за 1 комплект</td><td><?php echo $r['stavka']; ?> грн</td></tr>
        <tr><td>Базова вартість (кількість × ставка)</td><td><?php echo $r['baza']; ?> грн</td></tr>
        <tr><td>Знижка</td><td><?php echo $r['znizka_procent']; ?> % (мінус <?php echo $r['suma_znizky']; ?> грн)</td></tr>
        <tr><td>Монтаж (тільки для stage)</td><td><?php echo $r['montazh']; ?> грн</td></tr>
        <tr><td><b>Разом до сплати</b></td><td><b><?php echo $r['razom']; ?> грн</b></td></tr>
    </table>

    <p><a href="/../views/history.php">Переглянути історію замовлень</a></p>

<?php } ?>

</body>
</html>
