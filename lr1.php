<?php
$historyFile = 'events_history.json';
$history = file_exists($historyFile) ? json_decode(file_get_contents($historyFile), true) ?? [] : [];
$errors = [];
$successMessage = '';

$types = [
    'sound' => 900,
    'light' => 700,
    'stage' => 1500
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer = trim($_POST['customer'] ?? '');
    $quantity = (int)($_POST['quantity'] ?? 0);
    $type = $_POST['type'] ?? '';
    $date = $_POST['date'] ?? '';
    $description = trim($_POST['description'] ?? '');
    if (empty($customer)) {
        $errors[] = "Вкажіть ім'я";
    }
    
    if ($quantity < 1 || $quantity > 20) {
        $errors[] = "Кількість комплектів має бути від 1 до 20.";
    }
    
    if (!array_key_exists($type, $types)) {
        $errors[] = "Некоректний тип комплекту.";
    }
    $descBytes = strlen($description);
    if ($descBytes < 10 || $descBytes > 600) {
        $errors[] = "Опис має містити від 10 до 600 байтів (поточний розмір: $descBytes B).";
    }
    $tomorrow = date('Y-m-d', strtotime('+1 day'));
    if (empty($date) || $date < $tomorrow) {
        $errors[] = "Дата події має бути не раніше завтра ($tomorrow).";
    }

    