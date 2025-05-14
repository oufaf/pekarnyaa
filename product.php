<?php
session_start(); // ДОБАВЬ это в начале, если не было
require_once 'connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Некорректный ID товара.";
    exit;
}

$productId = (int)$_GET['id'];

// Получаем информацию о товаре из БД
$stmt = $connect->prepare("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "Товар не найден.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?></title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php require_once 'header.php';?>
<div class="product-detail">
    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    <h1><?= htmlspecialchars($product['name']) ?></h1>
    <div class="product-category">Категория: <?= htmlspecialchars($product['category_name']) ?></div>
    <div class="product-price"><?= number_format($product['price'], 2) ?> ₽</div>
    <div class="product-description"><?= nl2br(htmlspecialchars($product['description'])) ?></div>

    <!-- КНОПКИ -->
    <form action="add_to_cart.php" method="post" class="product-actions">
        <input type="hidden" name="id" value="<?= $productId ?>">
        <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
        <input type="hidden" name="price" value="<?= $product['price'] ?>">
        <input type="hidden" name="quantity" value="1">

        <button type="submit" name="action" value="add" class="btn-add-cart">Добавить в корзину</button>
        <button type="submit" name="action" value="buy" class="btn-buy-now">Купить</button>
    </form>

    <a href="catalog.php" class="back-link">← Назад в каталог</a>
</div>

<?php if (!empty($_SESSION['cart_success'])): ?>
<script>
Swal.fire({
    title: 'Товар добавлен!',
    text: 'Товар успешно добавлен в корзину.',
    icon: 'success',
    timer: 1500,
    showConfirmButton: false
});
</script>
<?php unset($_SESSION['cart_success']); ?>
<?php endif; ?>
</body>
</html>

<?php require_once 'footer.php'; ?>
