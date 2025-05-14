<?php
session_start();
require_once 'connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
        $stmt = $connect->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $username, $passwordHash);
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            if (password_verify($password, $passwordHash)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                header("Location: profile.php");
                exit();
            } else {
                $error = "Неверный пароль.";
            }
        } else {
            $error = "Пользователь с таким email не найден.";
        }
        $stmt->close();
    } else {
        $error = "Пожалуйста, заполните все поля корректно.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="login-container">
    <h2>Вход в аккаунт</h2>

    <?php if (!empty($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Пароль:</label>
        <div class="password-wrapper">
            <input type="password" id="password" name="password" required>
            <span class="toggle-password" onclick="togglePassword()">👁</span>
        </div>

        <button type="submit">Войти</button>
    </form>
</div>

<script>
function togglePassword() {
    const input = document.getElementById("password");
    const toggle = document.querySelector(".toggle-password");
    if (input.type === "password") {
        input.type = "text";
        toggle.textContent = "🙈";
    } else {
        input.type = "password";
        toggle.textContent = "👁";
    }
}
</script>


</body>
</html>
