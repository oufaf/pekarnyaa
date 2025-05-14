<?php
session_start();
require_once 'connect.php';

// Загружаем активные акции
$query = "SELECT * FROM sales WHERE is_active = 1 AND (end_date IS NULL OR end_date >= CURDATE()) ORDER BY start_date DESC";
$result = $connect->query($query);

$sales = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sales[] = $row;
    }
}

$connect->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акции и предложения</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require_once 'header.php'; ?>

<div class="sales-container">
    <h1>Наши акции</h1>
    <?php if (!empty($sales)): ?>
        <?php foreach ($sales as $sale): ?>
            <div class="sale-card">
                <?php if (!empty($sale['image'])): ?>
                    <img src="<?= htmlspecialchars($sale['image']) ?>" alt="<?= htmlspecialchars($sale['title']) ?>">
                <?php endif; ?>
                <div class="sale-content">
                    <h2><?= htmlspecialchars($sale['title']) ?></h2>
                    <p><?= nl2br(htmlspecialchars($sale['description'])) ?></p>
                    <div class="sale-dates">
                        <?= $sale['start_date'] ? 'С ' . htmlspecialchars($sale['start_date']) : '' ?>
                        <?= $sale['end_date'] ? ' по ' . htmlspecialchars($sale['end_date']) : '' ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Акции в данный момент не проводятся.</p>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>
</body>
</html>
