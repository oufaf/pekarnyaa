<?php
$hostname = "localhost";
$username = "root";  // Например: cj37909_root
$password = "";    // Пароль от базы данных
$database = "pekarnya.oc";      // Например: bakery_site

$connect = new mysqli($hostname, $username, $password, $database);
if ($connect->connect_error) {
    die("Ошибка подключения: " . $connect->connect_error);
}
$connect->set_charset("utf8");
?>