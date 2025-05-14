<?php
require_once 'connect.php';
$result = $connect->query("
    SELECT n.id, n.title, n.slug, n.content, n.image, n.published_at, nc.name AS category_name
    FROM news n
    JOIN news_categories nc ON n.category_id = nc.id
    WHERE n.is_active = 1
    ORDER BY n.published_at DESC
");
$newsItems = $result->fetch_all(MYSQLI_ASSOC);
$connect->close();
?>
<?php
require_once("header.php")
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новости | Пекарня у дома</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="news-container">
        <h1>Новости нашей пекарни</h1>
        <?php foreach ($newsItems as $news): ?>
            <div class="news-card" id="news-<?= $news['id'] ?>">
                <?php if ($news['image']): ?>
                    <img src="<?= htmlspecialchars($news['image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>">
                <?php endif; ?>
                <div class="news-content">
                    <div class="news-meta">
                        <?= date('d.m.Y', strtotime($news['published_at'])) ?> • <?= htmlspecialchars($news['category_name']) ?>
                    </div>
                    <h2 class="news-title"><?= htmlspecialchars($news['title']) ?></h2>
                    <p><?= mb_substr(strip_tags($news['content']), 0, 120) ?>...</p>
                    <a class="read-more" href="news_detail.php?id=<?= $news['id'] ?>">Читать далее</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
<?php require_once ("footer.php") ?>
