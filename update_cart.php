<?php
session_start();

if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        $id = (int)$id;
        $qty = (int)$qty;
        if ($qty > 0 && isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = $qty;
        }
    }
}

header('Location: cart.php');
exit;
