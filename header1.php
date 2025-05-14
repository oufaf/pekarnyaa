<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Пекарня у дома</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .header {
            background-color: #000;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 999;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
        }

        .menu {
            display: flex;
            gap: 20px;
        }

        .menu a {
            font-size: 1rem;
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .menu a:hover {
            background-color: #333;
        }

        .menu a.active {
            background-color: #f39c12;
            color: #fff;
        }

        @media (max-width: 768px) {
            .menu {
                display: none;
                position: absolute;
                top: 60px;
                right: 10px;
                background-color: #000;
                width: 200px;
                border-radius: 10px;
                flex-direction: column;
                align-items: center;
                gap: 15px;
                padding: 10px;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
            }

            .menu.active {
                display: flex;
            }

            .menu-toggle {
                display: block;
                background: none;
                border: none;
                color: white;
                font-size: 1.5rem;
                cursor: pointer;
                padding: 10px;
            }
        }

        .menu-toggle {
            display: none;
        }
    </style>
</head>
<body>
<header class="header">
    <div class="container">
        <div class="logo">
            <img src="croissant-icon.png" alt="Логотип" class="logo-img">
            <span class="logo-text">Пекарня у дома</span>
        </div>

        <button class="menu-toggle" id="menu-toggle">&#9776;</button>

        <nav class="menu" id="menu">
            <a href="index.php" <?= $currentPage == 'index.php' ? 'class="active"' : '' ?>>Главная</a>
            <a href="about.php" <?= $currentPage == 'about.php' ? 'class="active"' : '' ?>>О пекарне</a>
            <a href="categories.php" <?= $currentPage == 'categories.php' ? 'class="active"' : '' ?>>Каталог</a>
            <a href="sales.php" <?= $currentPage == 'sales.php' ? 'class="active"' : '' ?>>Акции</a>
            <a href="news.php" <?= $currentPage == 'news.php' ? 'class="active"' : '' ?>>Новости</a>
            <a href="reviews.php" <?= $currentPage == 'reviews.php' ? 'class="active"' : '' ?>>Отзывы</a>
            <a href="contacts.php" <?= $currentPage == 'contacts.php' ? 'class="active"' : '' ?>>Контакты</a>
            <a href="cart.php" <?= $currentPage == 'cart.php' ? 'class="active"' : '' ?>>Корзина</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profile.php" <?= $currentPage == 'profile.php' ? 'class="active"' : '' ?>>
                    <?= htmlspecialchars($_SESSION['username']) ?>
                </a>
                <a href="logout.php">Выйти</a>
            <?php else: ?>
                <a href="login.php" <?= $currentPage == 'login.php' ? 'class="active"' : '' ?>>Войти</a>
                <a href="register.php" <?= $currentPage == 'register.php' ? 'class="active"' : '' ?>>Регистрация</a>
            <?php endif; ?>
        </nav>
    </div>

</header>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');

    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('active');
    });

    document.querySelectorAll('.menu a').forEach(link => {
        link.addEventListener('click', function () {
            document.querySelectorAll('.menu a').forEach(item => item.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
</body>
</html>
