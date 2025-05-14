<?php
require_once("connect.php");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Футер сайта</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Создатели сайта</h3>
                <p class="creator-name">Роман Свёрной Андреевич</p>
                <p class="creator-name">Москва Мин Пилюнич</p>
                <p class="creator-name">Курицкая Роман Романович</p>
            </div>
            
            <div class="footer-section">
                <h3>Контактная информация</h3>
                <address class="contact-info">
                    <strong>Адрес:</strong> Пушкинская, 26<br>
                    <strong>Телефон:</strong> <a href="tel:+7023456799">+7 023 45 67 99</a>
                </address>
            </div>
            
            <div class="footer-divider"></div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date("Y"); ?> Все права защищены</p>
            </div>
        </div>
    </footer>
</body>
</html>