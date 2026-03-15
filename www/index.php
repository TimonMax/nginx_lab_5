<?php
session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/RepairRequest.php';

$req = new RepairRequest($pdo);
$all = $req->getAll();

$errors = $_SESSION['errors'] ?? null;
$success = $_SESSION['success'] ?? null;
$old = $_SESSION['old'] ?? null;
unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Заявки — ремонт техники</title>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <style> body{font-family:Arial,Helvetica,sans-serif;padding:18px} table{border-collapse:collapse;width:100%} th,td{border:1px solid #ddd;padding:8px} </style>
</head>
<body>
  <h1>Заявки на ремонт</h1>

  <?php if ($errors): ?>
    <div style="color:#900;background:#fee;padding:8px;border-radius:6px"><strong>Ошибки:</strong>
      <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
    </div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div style="color:#060;background:#efe;padding:8px;border-radius:6px"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <p><a href="form.html">Создать новую заявку</a></p>

  <h2>Сохранённые заявки</h2>
  <?php if (empty($all)): ?>
    <p>Записей пока нет.</p>
  <?php else: ?>
    <table>
      <tr><th>#</th><th>Имя</th><th>Модель</th><th>Email</th><th>Услуга</th><th>Гарантия</th><th>Срок</th><th>Время</th></tr>
      <?php foreach ($all as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['id']) ?></td>
          <td><?= htmlspecialchars($r['name']) ?></td>
          <td><?= htmlspecialchars($r['model']) ?></td>
          <td><?= htmlspecialchars($r['email']) ?></td>
          <td><?= htmlspecialchars($r['service']) ?></td>
          <td><?= $r['warranty'] ? 'Да' : 'Нет' ?></td>
          <td><?= htmlspecialchars($r['term']) ?></td>
          <td><?= htmlspecialchars($r['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>

  <?php if (!empty($_COOKIE['last_submission'])): ?>
    <p><b>Последняя отправка (cookie):</b> <?= htmlspecialchars($_COOKIE['last_submission']) ?></p>
  <?php endif; ?>
</body>
</html>