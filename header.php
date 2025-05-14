<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>
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
    menuToggle?.addEventListener('click', () => {
        menu?.classList.toggle('active');
    });
</script>
