<?php
session_start();
require_once 'connect.php';
require_once 'header.php';

// Если запрос на выход из системы
if (isset($_GET['logout'])) {
    // Завершаем сессию
    session_unset();
    session_destroy();
    header('Location: index.php'); // Перенаправление на главную страницу
    exit;
}

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $connect->prepare("SELECT name, email, avatar FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $avatar);
$stmt->fetch();
$stmt->close();

// Обработка формы изменения данных пользователя
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
    $new_email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $new_password = $_POST['password'] ?? '';
    $new_avatar = $_FILES['avatar'] ?? null;

    // Проверка данных
    if (filter_var($new_email, FILTER_VALIDATE_EMAIL) && !empty($new_name)) {
        $update_query = "UPDATE users SET name = ?, email = ?";

        // Если пароль изменяется, хешируем новый пароль
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query .= ", password = ?";
        }

        // Если аватар был загружен
        if ($new_avatar && $new_avatar['error'] === UPLOAD_ERR_OK) {
            $avatar_path = 'uploads/' . basename($new_avatar['name']);
            move_uploaded_file($new_avatar['tmp_name'], $avatar_path);
            $update_query .= ", avatar = ?";
        }

        $update_query .= " WHERE id = ?";
        $stmt = $connect->prepare($update_query);
        $params = [$new_name, $new_email];

        // Если пароль изменяется
        if (!empty($new_password)) {
            $params[] = $hashed_password;
        }

        // Если аватар был загружен
        if ($new_avatar && $new_avatar['error'] === UPLOAD_ERR_OK) {
            $params[] = $avatar_path;
        }

        $params[] = $user_id;
        $stmt->bind_param(str_repeat('s', count($params) - 1) . 'i', ...$params);
        $stmt->execute();
        $stmt->close();

        header('Location: profile.php');
        exit;
    } else {
        $error = "Пожалуйста, заполните все поля корректно.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="profile-container">
    <h1>Профиль пользователя</h1>
    <form action="profile.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Имя:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Новый пароль:</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="avatar">Аватар:</label>
            <input type="file" id="avatar" name="avatar" accept="image/*">
        </div>
        <button type="submit" class="save-btn">Сохранить изменения</button>
    </form>

    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <div class="profile-actions">
        <a href="index.php">Выйти</a>
    </div>
</div>

</body>
</html>

<?php require_once 'footer.php'; ?>
