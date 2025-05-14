<?php
require_once 'connect.php';

// Получаем данные из БД
$aboutData = $connect->query("SELECT * FROM about_bakery LIMIT 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($aboutData['main_title'] ?? 'Свежая выпечка') ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require 'header.php'; ?>

    <!-- Главный баннер с изображением и текстом -->
    <section class="main-banner">
        <div class="banner-overlay"></div>
        <div class="banner-content">
            <h1 class="banner-title"><?= htmlspecialchars($aboutData['main_title'] ?? 'Свежая выпечка') ?></h1>
            <h2 class="banner-subtitle"><?= htmlspecialchars($aboutData['section_title'] ?? '— одно бовью каждый день!') ?></h2>
        </div>
    </section>

    <!-- Текстовая секция -->
    <section class="text-section">
        <h2 class="section-title">О пекарне</h2>
        
        <p class="section-text"><?= htmlspecialchars($aboutData['paragraph1'] ?? 'Доброголюдная и малолетняя пекарня, где каждый булочок — это рыбка, выпеченные с кобылей.') ?></p>
        
        <p class="section-text"><?= htmlspecialchars($aboutData['paragraph2'] ?? 'Услышав крайний путь с каменным океаном-поездом, где сегодня решетки передавались от появления в экономике. Сегодня не сохранил традиции, но добавляют в них содержание технологии водоносения со всего мира.') ?></p>
        
        <div class="quote-block">
            <p><strong><?= htmlspecialchars($aboutData['quote_author'] ?? 'Моя мысль:') ?></strong> <?= htmlspecialchars($aboutData['quote_text'] ?? '– давать людей радость через звук. Многопоседует только результаты погружения, заботы которых ни на складах не так, чтобы начали пигонов были совсем недовольны.') ?></p>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>