<?php
session_start();
require_once 'connect.php';
require_once 'header.php';

// Получение данных
$headerData = $connect->query("SELECT * FROM header ORDER BY sort_order ASC")->fetch_all(MYSQLI_ASSOC);
$aboutData = $connect->query("SELECT * FROM about_bakery LIMIT 1")->fetch_assoc();

// Заголовки страницы
$pageTitle = $aboutData['main_title'] ?? 'Свежая выпечка — одно бовью каждый день!';
$pageDescription = 'Доброголюдная пекарня с традициями и современными технологиями';

// Получение категорий
$categoriesQuery = "SELECT * FROM categories ORDER BY name ASC";
$categoriesResult = $connect->query($categoriesQuery);
$categories = $categoriesResult->fetch_all(MYSQLI_ASSOC);

// Закрытие соединения с базой данных
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <!-- Слайдер изображений -->
        <div class="slider-container">
            <div class="slider">
                <div class="slide"><img src="1.jpg" alt="Свежая выпечка каждое утро"></div>
                <div class="slide"><img src="2.webp" alt="Натуральные ингредиенты"></div>
                <div class="slide"><img src="3.webp" alt="Уютная атмосфера пекарни"></div>
            </div>
            <div class="slider-arrow prev">&#10094;</div>
            <div class="slider-arrow next">&#10095;</div>
            <div class="slider-nav">
                <div class="slider-dot active"></div>
                <div class="slider-dot"></div>
                <div class="slider-dot"></div>
            </div>
        </div>

        <!-- О пекарне -->
        <section class="about-section">
            <div class="container">
                <div class="about-header">
                    <h2 class="section-title">О нашей пекарне</h2>
                    <p class="section-description"><?= htmlspecialchars($aboutData['short_description'] ?? 'Мы готовим с любовью, используя только натуральные ингредиенты, и придерживаемся лучших традиций пекарного искусства.') ?></p>
                </div>
                <div class="about-content">
                    <div class="about-text">
                        <h3 class="about-subtitle"><?= htmlspecialchars($aboutData['subtitle'] ?? 'Традиции и качество в каждой булочке') ?></h3>
                        <p><?= htmlspecialchars($aboutData['description'] ?? 'Наша пекарня - это место, где каждый день мы радуем вас свежей выпечкой. Мы используем только натуральные ингредиенты, придерживаясь старинных рецептов, чтобы каждая булочка приносила радость.') ?></p>
                        <a href="about.php" class="btn">Подробнее</a>
                    </div>
                    <div class="about-image">
                        <img src="<?= htmlspecialchars($aboutData['main_image'] ?? 'images/bakery-placeholder.jpg') ?>" alt="О нашей пекарне" class="img-responsive">
                    </div>
                </div>
            </div>
        </section>

        <!-- Категории продукции -->
        <section class="categories-section">
            <div class="container">
                <h2 class="section-title">Наши категории</h2>
                <div class="categories-list">
                    <?php foreach ($categories as $category): ?>
                        <div class="category-item">
                            <?php if (!empty($category['image'])): ?>
                                <img src="<?= htmlspecialchars($category['image']) ?>" alt="<?= htmlspecialchars($category['name']) ?>" class="category-image">
                            <?php endif; ?>
                            <h3 class="category-title"><?= htmlspecialchars($category['name']) ?></h3>
                            <a href="catalog.php?category_id=<?= $category['id'] ?>" class="btn">Посмотреть товары</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
// Получение активных акций (только 3 последние)
$salesQuery = "SELECT * FROM sales WHERE is_active = 1 AND (end_date IS NULL OR end_date >= CURDATE()) ORDER BY start_date DESC LIMIT 3";
$salesResult = $connect->query($salesQuery);
$sales = $salesResult && $salesResult->num_rows > 0 ? $salesResult->fetch_all(MYSQLI_ASSOC) : [];
?>

<!-- Наши акции -->
<?php if (!empty($sales)): ?>
<section class="promotions-section">
    <div class="container">
        <h2 class="section-title">Наши акции</h2>
        <div class="promotions-list">
            <?php foreach ($sales as $sale): ?>
                <div class="promotion-item">
                    <?php if (!empty($sale['image'])): ?>
                        <img src="<?= htmlspecialchars($sale['image']) ?>" alt="<?= htmlspecialchars($sale['title']) ?>" class="promotion-image">
                    <?php endif; ?>
                    <div class="promotion-content">
                        <h3 class="promotion-title"><?= htmlspecialchars($sale['title']) ?></h3>
                        <p class="promotion-description"><?= nl2br(htmlspecialchars($sale['description'])) ?></p>
                        <div class="promotion-dates">
                            <?= $sale['start_date'] ? 'С ' . htmlspecialchars($sale['start_date']) : '' ?>
                            <?= $sale['end_date'] ? ' по ' . htmlspecialchars($sale['end_date']) : '' ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="see-all-promotions">
            <a href="sales.php" class="btn">Смотреть все акции</a>
        </div>
    </div>
</section>
<?php endif; ?>


    </main>
    <?php include 'footer.php'; ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.querySelector('.slider');
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.slider-dot');
        const prevArrow = document.querySelector('.slider-arrow.prev');
        const nextArrow = document.querySelector('.slider-arrow.next');
        let slideIndex = 0;
        const totalSlides = slides.length;

        function updateSlider() {
            slider.style.transform = `translateX(-${slideIndex * 100}%)`;
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === slideIndex);
            });
        }

        nextArrow.addEventListener('click', () => {
            slideIndex = (slideIndex + 1) % totalSlides;
            updateSlider();
        });

        prevArrow.addEventListener('click', () => {
            slideIndex = (slideIndex - 1 + totalSlides) % totalSlides;
            updateSlider();
        });

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                slideIndex = index;
                updateSlider();
            });
        });

        setInterval(() => {
            slideIndex = (slideIndex + 1) % totalSlides;
            updateSlider();
        }, 5000);

        updateSlider();
    });
    </script>
</body>
</html>
