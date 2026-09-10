<?php

function perevirka_kilkist($kilkist) {
    if ($kilkist === '' || $kilkist === null) {
        return 'Вкажіть кількість комплектів';
    }
    if (!is_numeric($kilkist)) {
        return 'Кількість має бути числом';
    }
    $kilkist = (int)$kilkist;
    if ($kilkist < 1 || $kilkist > 20) {
        return 'Кількість комплектів має бути від 1 до 20';
    }
    return '';
}


function perevirka_typu($tip) {
    $dozvoleni = array('sound', 'light', 'stage');
    if (!in_array($tip, $dozvoleni)) {
        return 'Оберіть правильний тип комплекту';
    }
    return '';
}


function perevirka_daty($data_str) {
    if ($data_str === '' || $data_str === null) {
        return 'Вкажіть дату події';
    }


    $data_podiyi = strtotime($data_str);
    if ($data_podiyi === false) {
        return 'Невірний формат дати';
    }


    $zavtra = strtotime('+1 day', strtotime(date('Y-m-d')));

    if ($data_podiyi < $zavtra) {
        return 'Дата події не може бути раніше завтрашнього дня';
    }
    return '';
}


function perevirka_opysu($opys) {
    if ($opys === '' || $opys === null) {
        return 'Вкажіть опис події';
    }


    $dovzhyna = strlen($opys);

    if ($dovzhyna < 10) {
        return 'Опис закороткий, мінімум 10 байт';
    }
    if ($dovzhyna > 600) {
        return 'Опис задовгий, максимум 600 байт';
    }
    return '';
}


function perevirka_zamovnyka($zamovnyk) {
    if (trim($zamovnyk) === '') {
        return 'Вкажіть імя замовника';
    }
    return '';
}
