<?php

define('FAIL_ZAMOVLEN', __DIR__ . '/../data/zamovlennya.json');


function zberegty_zamovlennya($zamovlennya) {
    $vsi = zavantazhyty_vsi_zamovlennya();
    $vsi[] = $zamovlennya;

    $json = json_encode($vsi, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    file_put_contents(FAIL_ZAMOVLEN, $json);
}

// читає всі замовлення з файлу
function zavantazhyty_vsi_zamovlennya() {
    if (!file_exists(FAIL_ZAMOVLEN)) {
        return array();
    }

    $vmist = file_get_contents(FAIL_ZAMOVLEN);
    if ($vmist === false || $vmist === '') {
        return array();
    }

    $masyv = json_decode($vmist, true);
    if ($masyv === null) {
        return array();
    }

    return $masyv;
}
