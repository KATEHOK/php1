<?php
header("Location: ./add_product.php");
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
// Для наглядности создаю переменные
$prodactName = $_POST['name'];
$description = $_POST['description'];
$productPrice = $_POST['price'];
$productCount = $_POST['count'];
$userId = $_POST['user_id'];
$imgName = $_FILES['img']['name'];
$imgTmpName = $_FILES['img']['tmp_name'];
// Проверяю, не пусты ли эти переменные
if (empty($_FILES['img']) || !isset($prodactName) || !isset($description) || !isset($productPrice) || !isset($productCount) || !isset($userId)) {
    exit;
}
// var_dump($_FILES['img']);
// echo '<br>';
// var_dump($_POST);
// Для наглядности запсос к БД тоже делаю переменной
$query = "insert into catalog (`name`, price, count, img, creator_id, description) values ('$prodactName', $productPrice, $productCount, '$imgName', $userId, '$description');";
// Импортирую файл, подключающий БД
include("./db_open.php");
// Выполняю запрос к БД
$result = mysqli_query($link, $query);
// Выключаем выполнение скрипта, если не удалось записать данные в БД (например, в моей БД настроена уникальность имен товаров)
if (!$result) {
    exit;
}
// Перемещаю картинку в директорию с изображениями
move_uploaded_file($imgTmpName, "../img/$imgName");
// Импортирую файл, отключающий от БД
include("./db_close.php");
