<?php
session_start();
require_once 'connect.php';

header('Content-Type: application/json');

$response = ['success' => false];
if (!isset($_SESSION['user_id'])) {
    // Если нет, перенаправляем на страницу входа с параметром error
    $_SESSION['error_message'] = 'Сначала выполните вход в аккаунт';
    header('Location: login.php'); // Перенаправление на страницу входа
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];

    $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (!isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = [
                'id' => $productId,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        } else {
            $_SESSION['cart'][$productId]['quantity']++;
        }

        $response['success'] = true;
        $response['message'] = "Товар «{$product['name']}» успешно добавлен в корзину!";
    }
}

echo json_encode($response);
exit;
