<?php
session_start();
require_once 'connect.php';
require_once 'header.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0;

// Получаем данные пользователя из сессии
$userName = $_SESSION['user_name'] ?? '';
$userPhone = $_SESSION['user_phone'] ?? '';
$userAddress = $_SESSION['user_address'] ?? '';

// Если форма отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Если данные не были переданы, используем данные из сессии
    $name = $_POST['name'] ?? $userName;
    $phone = $_POST['phone'] ?? $userPhone;
    $address = $_POST['address'] ?? $userAddress;

    if ($name && $phone && $address && !empty($cart)) {
        // Подсчёт общей суммы
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Сохраняем заказ
        $stmt = $connect->prepare("INSERT INTO orders (address, total, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("sd", $address, $total);

        if ($stmt->execute()) {
            $orderId = $stmt->insert_id;

            // Сохраняем товары заказа
            $itemStmt = $connect->prepare("INSERT INTO order_items (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
            foreach ($cart as $item) {
                $itemStmt->bind_param("isdi", $orderId, $item['name'], $item['price'], $item['quantity']);
                $itemStmt->execute();
            }

            // Очищаем корзину
            unset($_SESSION['cart']);
            echo "<script>alert('Спасибо за заказ!'); window.location.href='index.php';</script>";
            exit;
        } else {
            echo "Ошибка при оформлении заказа: " . $stmt->error;
        }
    } else {
        echo "<p style='color: red;'>Пожалуйста, заполните все поля и убедитесь, что корзина не пуста.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
</body>
</html>

<div class="checkout-container">
    <h1>Оформление заказа</h1>

    <?php if (!empty($cart)): ?>
        <table class="cart-summary">
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Кол-во</th>
                    <th>Сумма</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price'], 2) ?> ₽</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($subtotal, 2) ?> ₽</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p class="total-amount">Общая сумма: <strong><?= number_format($total, 2) ?> ₽</strong></p>

        <form method="POST" class="checkout-form">
            <h2>Ваши данные</h2>
            <input type="text" name="name" placeholder="Ваше имя" value="<?= htmlspecialchars($userName) ?>" required><br><br>
            <input type="text" name="phone" placeholder="Телефон" value="<?= htmlspecialchars($userPhone) ?>" required><br><br>
            <textarea name="address" placeholder="Адрес доставки" required><?= htmlspecialchars($userAddress) ?></textarea><br><br>
            <button type="submit" class="btn-submit">Подтвердить заказ</button>
        </form>
    <?php else: ?>
        <p class="empty-cart">Корзина пуста. <a href="index.php">На главную</a></p>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>
