<?php
require_once __DIR__ . '/../vendor/autoload.php';

function e($value)
{
    if ($value === null) {
        return '';
    }
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function handleForm()
{
    $processor = new SubmissionProcessor();

    $old = array(
        'customer' => '',
        'sets' => '',
        'type' => '',
        'date' => '',
        'description' => ''
    );
    $errors = array();
    $result = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($processor->process($_POST)) {
            $result = $processor->result;
        } else {
            $old = $processor->data;
            $errors = $processor->errors;
        }
    }

    return array(
        'old' => $old,
        'errors' => $errors,
        'result' => $result
    );
}

function handleHistory()
{
    $processor = new SubmissionProcessor();
    $filterType = isset($_GET['type']) ? $_GET['type'] : '';
    if ($filterType !== 'sound' && $filterType !== 'light' && $filterType !== 'stage') {
        $filterType = '';
    }

    return array(
        'orders' => $processor->getHistory($filterType),
        'filterType' => $filterType
    );
}

function checkTest($name, $expected, $actual)
{
    if (abs($expected - $actual) < 0.01) {
        echo "OK   | $name | отримано: $actual\n";
    } else {
        echo "FAIL | $name | очікували: $expected, отримали: $actual\n";
    }
}

function runBoundaryTest()
{
    $processor = new SubmissionProcessor();

    echo " ЗНИЖКИ: 4 і 5 комплектів\n\n";
    $four = $processor->calculatePrice('sound', 4);
    checkTest('sound 4 - база', 3600, $four['base']);
    checkTest('sound 4 - відсоток знижки', 0, $four['discountPercent']);
    checkTest('sound 4 - разом', 3600, $four['total']);

    echo "\n";
    $five = $processor->calculatePrice('sound', 5);
    checkTest('sound 5 - база', 4500, $five['base']);
    checkTest('sound 5 - відсоток знижки', 7, $five['discountPercent']);
    checkTest('sound 5 - сума знижки', 315, $five['discountSum']);
    checkTest('sound 5 - разом', 4185, $five['total']);

    echo "\nОДНОРАЗОВИЙ МОНТАЖ \n\n";

    $stageOne = $processor->calculatePrice('stage', 1);
    checkTest('stage 1 - монтаж', 800, $stageOne['assembly']);
    checkTest('stage 1 - разом', 2300, $stageOne['total']);


    $stageFour = $processor->calculatePrice('stage', 4);
    checkTest('stage 4 - монтаж не помножений', 800, $stageFour['assembly']);
    checkTest('stage 4 - разом', 6800, $stageFour['total']);
    $stageFive = $processor->calculatePrice('stage', 5);
    checkTest('stage 5 - сума знижки', 525, $stageFive['discountSum']);
    checkTest('stage 5 - монтаж не помножений', 800, $stageFive['assembly']);
    checkTest('stage 5 - разом', 7775, $stageFive['total']);

    echo "\n";


    checkTest('монтаж 1 = монтаж 4', $stageOne['assembly'], $stageFour['assembly']);
    checkTest('монтаж 4 = монтаж 5', $stageFour['assembly'], $stageFive['assembly']);

    echo "\n===== Тест завершено =====\n";
}
$runningFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath($_SERVER['SCRIPT_FILENAME']) : '';
if (php_sapi_name() == 'cli' && $runningFile == realpath(__FILE__)) {
    runBoundaryTest();
}
