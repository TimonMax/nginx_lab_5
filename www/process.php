<?php

session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/RepairRequest.php';

$req = new RepairRequest($pdo);


function post($name) {
    return $_POST[$name] ?? '';
}

$name = trim(post('name'));
$model = trim(post('model'));
$email = trim(post('email'));
$service = trim(post('service'));
$warranty = isset($_POST['warranty']) ? 1 : 0;
$term = trim(post('term'));

$errors = [];
if ($name === '') $errors[] = 'Имя не может быть пустым';
if ($model === '') $errors[] = 'Модель не может быть пустой';
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Некорректный email';

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = [
        'name' => htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE),
        'model' => htmlspecialchars($model, ENT_QUOTES | ENT_SUBSTITUTE),
        'email' => htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE),
        'service' => $service,
        'warranty' => $warranty,
        'term' => $term
    ];
    header('Location: index.php');
    exit();
}

try {
    $id = $req->add($name, $model, $email ?: null, $service, $warranty, $term);
    setcookie('last_submission', date('Y-m-d H:i:s'), time() + 3600, "/");
    $_SESSION['success'] = 'Заявка сохранена (ID: ' . $id . ')';
} catch (\Throwable $e) {
    $_SESSION['errors'] = ['Ошибка при сохранении: ' . $e->getMessage()];
}

header('Location: index.php');
exit();