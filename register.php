<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password) && !empty($name)) {
        require_once 'connect.php';

        $stmt = $connect->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Пользователь с таким email уже существует.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $connect->prepare("INSERT INTO users (email, password, name) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $hashedPassword, $name);
            $stmt->execute();

            $message = "Регистрация прошла успешно!";
        }

        $stmt->close();
        $connect->close();
    } else {
        $message = "Пожалуйста, заполните все поля корректно.";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Регистрация</h2>
        <form method="POST" action="register.php">
            <label for="name">Имя:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Зарегистрироваться</button>
        </form>

        <?php if (!empty($message)): ?>
            <div class="message <?= strpos($message, 'успешно') !== false ? 'success' : '' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Лёгкая анимация при вводе
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.style.backgroundColor = "#fffdfd";
            });
            input.addEventListener('blur', () => {
                input.style.backgroundColor = "#fff";
            });
        });
    </script>
</body>
</html>
