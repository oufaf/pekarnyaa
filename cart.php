<?php
session_start();
require_once 'header.php';

// Получаем корзину из сессии
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="cart-container">
    <h1>Корзина</h1>

    <?php if (!empty($cart)): ?>
        <form action="update_cart.php" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Кол-во</th>
                        <th>Итого</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($cart as $id => $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price'], 2) ?> ₽</td>
                        <td>
                            <input type="number" name="quantities[<?= $id ?>]" value="<?= $item['quantity'] ?>" min="1">
                        </td>
                        <td><?= number_format($subtotal, 2) ?> ₽</td>
                        <td>
                            <a href="remove_from_cart.php?id=<?= $id ?>" class="btn-remove">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn-checkout">Обновить количество</button>
        </form>

        <div class="cart-total">
            Общая сумма: <?= number_format($total, 2) ?> ₽
        </div>
        <a href="checkout.php" class="btn-checkout">Оформить заказ</a>
    <?php else: ?>
        <p class="empty-cart">Ваша корзина пуста.</p>
    <?php endif; ?>
</div>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Удаление товара с подтверждением
    document.querySelectorAll('.btn-remove').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;

            Swal.fire({
                title: 'Удалить товар?',
                text: 'Вы уверены, что хотите удалить этот товар из корзины?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Удалить',
                cancelButtonText: 'Отмена'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });

    // Визуальное подтверждение обновления корзины
    const updateForm = document.querySelector('form[action="update_cart.php"]');
    if (updateForm) {
        updateForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(updateForm);

            fetch('update_cart.php', {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    Swal.fire({
                        title: 'Обновлено!',
                        text: 'Корзина успешно обновлена.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload(); // Перезагрузка страницы после обновления
                    });
                }
            });
        });
    }
});
</script>


<?php require_once 'footer.php'; ?>
