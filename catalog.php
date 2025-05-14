<?php
require_once 'connect.php';

// Загружаем все категории
$categoriesResult = $connect->query("SELECT * FROM categories ORDER BY name");
$allCategories = [];
if ($categoriesResult && $categoriesResult->num_rows > 0) {
    while ($cat = $categoriesResult->fetch_assoc()) {
        $allCategories[] = $cat;
    }
}

// Получаем ID выбранной категории из GET-параметра
$selectedCategoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

// Загружаем товары по категории (если выбрана)
$query = "
    SELECT p.*, c.name AS category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.available = 1
";

if ($selectedCategoryId > 0) {
    $query .= " AND p.category_id = $selectedCategoryId";
}

$query .= " ORDER BY p.name";

$result = $connect->query($query);

$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$connect->close();
require_once 'header.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог продукции</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
</head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('.add-to-cart-form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const productId = this.dataset.productId;

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'product_id=' + encodeURIComponent(productId)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Товар добавлен!',
                        text: 'Успешно добавлено в корзину.',
                        icon: 'success',
                        confirmButtonText: 'ОК',
                        footer: '<a href="cart.php" style="color:#f39c12; text-decoration:underline;">Перейти в корзину</a>'
                    });
                } else {
                    Swal.fire({
                        title: 'Ошибка!',
                        text: 'Не удалось добавить товар.',
                        icon: 'error',
                        confirmButtonText: 'ОК'
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    title: 'Ошибка!',
                    text: 'Произошла ошибка при добавлении.',
                    icon: 'error',
                    confirmButtonText: 'ОК'
                });
            });
        });
    });
});
</script>

<body>
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert-success">
        <?= htmlspecialchars($_SESSION['success_message']) ?>
        <?php unset($_SESSION['success_message']); ?>
    </div>
<?php endif; ?>

<div class="catalog-container">
    <h1>Каталог продукции</h1>

    <!-- Выводим список категорий -->
    <div class="categories">
        <a href="catalog.php" <?= $selectedCategoryId === 0 ? 'class="active"' : '' ?>>Все категории</a>
        <?php foreach ($allCategories as $category): ?>
            <a href="catalog.php?category_id=<?= $category['id'] ?>"
               <?= $selectedCategoryId === (int)$category['id'] ? 'class="active"' : '' ?>>
                <?= htmlspecialchars($category['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Выводим товары -->
        <div class="product-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        <div class="product-category"><?= htmlspecialchars($product['category_name']) ?></div>
        <h3><?= htmlspecialchars($product['name']) ?></h3>
        <p><?= htmlspecialchars($product['description']) ?></p>
        <div class="product-price"><?= number_format($product['price'], 2) ?> ₽</div>
        
        <!-- Контейнер для кнопок -->
        <div class="product-actions">
        <form class="add-to-cart-form" data-product-id="<?= $product['id'] ?>">
            <button type="submit" class="btn-cart">В корзину</button>
        </form>
            <a href="product.php?id=<?= $product['id'] ?>" class="btn-detail">Подробнее</a>
        </div>
    </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Нет доступных товаров в этой категории.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

<?php require_once 'footer.php'; ?>

