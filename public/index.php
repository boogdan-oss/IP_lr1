<?php

require_once __DIR__ . '/../src/submisiion.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'form';

if ($page == 'history') {

    $view = handleHistory();
    $orders = $view['orders'];
    $filterType = $view['filterType'];

    require __DIR__ . '/../views/history.php';

} else {

    $view = handleForm();
    $old = $view['old'];
    $errors = $view['errors'];
    $result = $view['result'];

    require __DIR__ . '/../views/form.php';
}
