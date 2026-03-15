<?php
session_start();

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/RepairRequest.php';

$req = new RepairRequest($pdo);

// Обработка отправки формы (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';

    if ($id <= 0) {
        $_SESSION['errors'] = ['Некорректный ID'];
        header('Location: index.php');
        exit();
    }
    if ($name === '') {
        $_SESSION['errors'] = ['Имя не может быть пустым'];
        header('Location: edit.php?id=' . $id);
        exit();
    }

    try {
        $ok = $req->update($id, $name);
        if ($ok) {
            $_SESSION['success'] = "Запись #{$id} обновлена.";
        } else {
            $_SESSION['errors'] = ["Не удалось обновить запись #{$id}."];
        }
    } catch (\Throwable $e) {
        $_SESSION['errors'] = ['Ошибка при обновлении: ' . $e->getMessage()];
    }

    header('Location: index.php');
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    $_SESSION['errors'] = ['Некорректный ID'];
    header('Location: index.php');
    exit();
}

$row = $req->getById($id);
if (!$row) {
    $_SESSION['errors'] = ['Запись не найдена'];
    header('Location: index.php');
    exit();
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Редактировать заявку #<?= htmlspecialchars($row['id']) ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <style>
    form{width:320px;margin:30px auto;padding:20px;border:1px solid #ccc;border-radius:6px}
    input,button{width:100%;padding:6px;margin:6px 0;box-sizing:border-box}
  </style>
</head>
<body>
  <h1>Редактировать заявку #<?= htmlspecialchars($row['id']) ?></h1>

  <?php if (!empty($_SESSION['errors'])): ?>
    <div style="color:#900;background:#fee;padding:8px;border-radius:6px">
      <ul>
        <?php foreach ($_SESSION['errors'] as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
  <?php unset($_SESSION['errors']); ?>

  <form method="post" action="edit.php">
    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
    <label>Имя:
      <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
    </label>
    <button type="submit">Сохранить</button>
  </form>

  <p><a href="index.php">← Назад</a></p>
</body>
</html>