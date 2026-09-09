<?php



require_once __DIR__ . '/calculation.php';


function perevirty($nazva_testu, $ochikuvane, $otrymane)
{
    if ($ochikuvane == $otrymane) {
        echo "OK   - $nazva_testu (отримано: $otrymane)\n";
    } else {
        echo "FAIL - $nazva_testu (очікували $ochikuvane, отримали $otrymane)\n";
    }
}

echo "===== ГРАНИЧНИЙ ТЕСТ: 4 і 5 комплектів =====\n\n";


$test1 = rozrahuvaty_vartist('sound', 4);
perevirty('sound 4 комплекти - база', 3600, $test1['baza']);
perevirty('sound 4 комплекти - знижка відсоток', 0, $test1['znizka_procent']);
perevirty('sound 4 комплекти - разом (без знижки)', 3600, $test1['razom']);

echo "\n";


$test2 = rozrahuvaty_vartist('sound', 5);
perevirty('sound 5 комплектів - база', 4500, $test2['baza']);
perevirty('sound 5 комплектів - знижка відсоток', 7, $test2['znizka_procent']);
perevirty('sound 5 комплектів - сума знижки', 315, $test2['suma_znizky']);
perevirty('sound 5 комплектів - разом (зі знижкою)', 4185, $test2['razom']);

echo "\n===== ТЕСТ МОНТАЖУ STAGE (один раз, не за кожен комплект) =====\n\n";
$test3 = rozrahuvaty_vartist('stage', 1);
perevirty('stage 1 комплект - монтаж', 800, $test3['montazh']);
perevirty('stage 1 комплект - разом', 2300, $test3['razom']);

echo "\n";
$test4 = rozrahuvaty_vartist('stage', 3);
perevirty('stage 3 комплекти - монтаж однаковий (не множиться)', 800, $test4['montazh']);
perevirty('stage 3 комплекти - разом', 5300, $test4['razom']);

echo "\n";
$test5 = rozrahuvaty_vartist('stage', 5);
perevirty('stage 5 комплектів - база', 7500, $test5['baza']);
perevirty('stage 5 комплектів - сума знижки', 525, $test5['suma_znizky']);
perevirty('stage 5 комплектів - монтаж', 800, $test5['montazh']);
perevirty('stage 5 комплектів - разом (знижка + монтаж)', 7775, $test5['razom']);

echo "\n===== Кінець тестів =====\n";
?>