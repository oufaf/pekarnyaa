<?php
require_once 'connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$news = null;

if ($id > 0) {
    $stmt = $connect->prepare("
        SELECT n.*, nc.name AS category_name
        FROM news n
        JOIN news_categories nc ON n.category_id = nc.id
        WHERE n.id = ? AND n.is_active = 1
        LIMIT 1
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $news = $result->fetch_assoc();
    $stmt->close();
}

$connect->close();

if (!$news) {
    http_response_code(404);
    echo "<h1>Новость не найдена</h1>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($news['title']) ?> | Пекарня</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #fff9f2;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .news-detail {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .news-detail img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .news-detail h1 {
            margin: 0 0 10px;
            font-size: 2rem;
        }
        .news-meta {
            font-size: 0.9rem;
            color: #999;
            margin-bottom: 20px;
        }
        .news-content {
            line-height: 1.6;
            font-size: 1rem;
        }
        .back-link {
            display: inline-block;
            margin-top: 30px;
            text-decoration: none;
            color: #f39c12;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="news-detail">
        <?php if (!empty($news['image'])): ?>
            <img src="<?= htmlspecialchars($news['image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>">
        <?php endif; ?>

        <h1><?= htmlspecialchars($news['title']) ?></h1>
        <div class="news-meta">
            <?= date('d.m.Y', strtotime($news['published_at'])) ?> • <?= htmlspecialchars($news['category_name']) ?>
        </div>
        <div class="news-content">
            <?= nl2br(htmlspecialchars($news['content'])) ?>
        </div>

        <a href="news.php" class="back-link">← Вернуться ко всем новостям</a>
    </div>
</body>
</html>
