<?php
// Подключаем файл для соединения с базой данных
require_once 'connect.php';
require_once 'header.php'; // Если есть header.php

// Запрос к базе данных для получения всех категорий
$query = "SELECT * FROM categories ORDER BY name";
$result = $connect->query($query);

// Если запрос успешен и есть категории
$categories = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
} else {
    // Если категорий нет в базе данных
    $categories = null;
}

// Закрытие соединения с базой данных
$connect->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Категории продукции</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require_once "header.php"; ?>
    
    <div class="categories-container">
        <h1 style="margin-bottom: 30px; text-align: center;">Категории продукции</h1>
        <?php if ($categories): ?>
            <div class="categories-list">
                <?php foreach ($categories as $category): ?>
                    <div class="category-item">
                        <?php if (!empty($category['image'])): ?>
                            <img src="<?= htmlspecialchars($category['image']) ?>" alt="<?= htmlspecialchars($category['name']) ?>" class="category-img">
                        <?php endif; ?>
                        <h2><?= htmlspecialchars($category['name']) ?></h2>
                        <a href="catalog.php?category_id=<?= $category['id'] ?>" class="view-products-btn">Посмотреть товары</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Категории не найдены.</p>
        <?php endif; ?>
    </div>

    <?php require_once 'footer.php'; // Если есть footer.php ?>
</body>
</html>