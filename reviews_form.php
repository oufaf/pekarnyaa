<?php
require_once("connect.php")
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($name) && !empty($message)) {
        // Подключение к базе данных
        require_once 'connect.php';

        // Подготовка и выполнение запроса
        $stmt = $connect->prepare("INSERT INTO reviews (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        $stmt->execute();
        $stmt->close();

        echo "<p>Спасибо за ваш отзыв!</p>";
    } else {
        echo "<p>Пожалуйста, заполните все поля корректно.</p>";
    }
}
?>
<?php
require_once("header.php") ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <style>
        form {
    width: 300px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

form label {
    display: block;
    margin-bottom: 5px;
}

form input,
form textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form button {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

form button:hover {
    background-color: #218838;
}

.review {
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f1f1f1;
    border-radius: 8px;
}

.review p {
    margin: 5px 0;
}

    </style>
<body>
<form action="reviews_form.php" method="POST">
    <label for="name">Ваше имя:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="email">Ваш email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="message">Ваш отзыв:</label>
    <textarea id="message" name="message" required></textarea><br>

    <button type="submit">Отправить отзыв</button>
</form>
</body>
</html>
<?php
require_once("footer.php")
?>

