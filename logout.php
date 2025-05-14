<?php
session_start();
session_unset();
session_destroy();
$redirectTo = $_SERVER['HTTP_REFERER'] ?? 'index.php'; // Если REFERER не задан, редирект на главную
header("Location: $redirectTo");
exit();
?>
