<?php
session_start();
require_once 'connect.php';
require_once 'header.php';

// Проверим, авторизован ли пользователь
$isLoggedIn = isset($_SESSION['user_id']);

// Получаем отзывы
$reviews = [];
$result = $connect->query("SELECT name, message, created_at FROM reviews ORDER BY created_at DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
</body>
</html>
<div class="reviews-container">
    <h1>Отзывы клиентов</h1>

    <button id="leaveReviewBtn">Оставить отзыв</button>

    <?php if ($isLoggedIn): ?>
        <form id="reviewForm" method="POST">
            <input type="text" name="name" placeholder="Ваше имя" required>
            <textarea name="message" rows="4" placeholder="Ваш отзыв" required></textarea>
            <button type="submit">Отправить отзыв</button>
        </form>
    <?php endif; ?>

    <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $r): ?>
            <div class="review-box">
                <p><?= htmlspecialchars($r['message']) ?></p>
                <p class="review-author">— <?= htmlspecialchars($r['name']) ?>, <?= date('d.m.Y', strtotime($r['created_at'])) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Пока отзывов нет.</p>
    <?php endif; ?>
</div>

<script>
document.getElementById('leaveReviewBtn').addEventListener('click', () => {
    <?php if ($isLoggedIn): ?>
        document.getElementById('reviewForm').style.display = 'block';
        document.getElementById('leaveReviewBtn').style.display = 'none';
    <?php else: ?>
        alert("Необходимо выполнить вход в аккаунт!");
    <?php endif; ?>
});
</script>

<?php
// Обработка отправки отзыва
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isLoggedIn) {
    $name = htmlspecialchars(trim($_POST['name']));
    $message = htmlspecialchars(trim($_POST['message']));
    $userId = $_SESSION['user_id'];

    if (!empty($name) && !empty($message)) {
        $stmt = $connect->prepare("INSERT INTO reviews (user_id, name, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $name, $message);
        $stmt->execute();
        echo "<script>alert('Спасибо за отзыв!'); window.location.href='reviews.php';</script>";
    }
}

require_once 'footer.php';
?>
