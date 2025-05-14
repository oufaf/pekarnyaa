<?php
require_once 'header.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Контакты</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <img src="https://via.placeholder.com/100" alt="..." class="team-avatar">
<div class="contacts-wrapper container">
    <h1>Наша команда</h1>
    <div class="team-list">
        <div class="team-member">
            <img src="images/ivan.jpg" alt="Иван Мальцев" class="team-avatar">
            <h2>Иван Мальцев</h2>
            <p>Разработчик интерфейса. Отвечает за дизайн, верстку и интерактивность сайта. Вдохновляется скандинавской выпечкой.</p>
            <a href="https://t.me/timedik" target="_blank" class="tg-link"><i class="bi bi-telegram"></i> @ivanmalcev</a>
        </div>

        <div class="team-member">
            <img src="images/saveliy.jpg" alt="Савелий Рожин" class="team-avatar">
            <h2>Савелий Рожин</h2>
            <p>Бэкенд-разработчик. Отвечает за базу данных, обработку заказов и авторизацию. Любит кофе и багеты.</p>
            <a href="https://t.me/sav_elka" target="_blank" class="tg-link"><i class="bi bi-telegram"></i> @sava_rozhin</a>
        </div>

        <div class="team-member">
            <img src="images/roman.jpg" alt="Роман Кузнецов" class="team-avatar">
            <h2>Роман Кузнецов</h2>
            <p>Тестировщик и аналитик. Проверяет функциональность сайта и помогает сделать интерфейс удобным. Увлекается аналитикой вкусов.</p>
            <a href="https://t.me/popa_bobra0905" target="_blank" class="tg-link"><i class="bi bi-telegram"></i> @roma_kuz</a>
        </div>
    </div>
</div>


<?php require_once 'footer.php'; ?>
</body>
</html>
