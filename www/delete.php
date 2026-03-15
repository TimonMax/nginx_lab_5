<?php
session_start();

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/RepairRequest.php';

if (!isset($_GET['id'])) {
    $_SESSION['errors'] = ['ID не передан'];
    header('Location: index.php');
    exit();
}

$id = (int)$_GET['id'];
if ($id <= 0) {
    $_SESSION['errors'] = ['Неверный ID'];
    header('Location: index.php');
    exit();
}

$req = new RepairRequest($pdo);

try {
    $ok = $req->delete($id);
    if ($ok) {
        $_SESSION['success'] = "Запись #{$id} успешно удалена.";
    } else {
        $_SESSION['errors'] = ["Не удалось удалить запись #{$id}."];
    }
} catch (\Throwable $e) {
    $_SESSION['errors'] = ['Ошибка при удалении: ' . $e->getMessage()];
}

header('Location: index.php');
exit();