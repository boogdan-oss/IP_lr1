<?php



// ціни за один комплект (грн)
define('CENA_SOUND', 900);
define('CENA_LIGHT', 700);
define('CENA_STAGE', 1500);


define('ZNIZKA_PROCENT', 7);


define('MONTAZH_STAGE', 800);



function rozrahuvaty_vartist($tip, $kilkist)
{

    // спочатку визначаємо ставку за тип
    if ($tip == 'sound') {
        $stavka = CENA_SOUND;
    } elseif ($tip == 'light') {
        $stavka = CENA_LIGHT;
    } elseif ($tip == 'stage') {
        $stavka = CENA_STAGE;
    } else {
        // якщо тип невідомий - ставка 0, помилку обробимо окремо
        $stavka = 0;
    }

    // базова вартість = кількість * ставка
    $baza = $kilkist * $stavka;

    // рахуємо знижку окремо, щоб було видно суму знижки
    $suma_znizky = 0;
    if ($kilkist >= 5) {
        $suma_znizky = $baza * (ZNIZKA_PROCENT / 100);
    }

    $pislya_znizky = $baza - $suma_znizky;

    // монтаж додається один раз, не множиться на кількість комплектів
    $montazh = 0;
    if ($tip == 'stage') {
        $montazh = MONTAZH_STAGE;
    }

    $razom = $pislya_znizky + $montazh;

    // повертаємо все проміжними кроками - зручно для тесту і для показу користувачу
    $rezultat = array(
        'tip' => $tip,
        'kilkist' => $kilkist,
        'stavka' => $stavka,
        'baza' => $baza,
        'znizka_procent' => ($kilkist >= 5) ? ZNIZKA_PROCENT : 0,
        'suma_znizky' => $suma_znizky,
        'montazh' => $montazh,
        'razom' => $razom
    );

    return $rezultat;
}
?>
