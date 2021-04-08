<?php
require_once('./user_filter.php');
// преадрессация на админ каталог
header('Location: ./');
// Импортирую файл, подключающий БД
include("../private/db_open.php");
// Для наглядности создаю переменные, применяя функции защиты и удаления пробельных символов
$prodactName = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['name']))));
$description = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['description']))));
$productPrice = (float)($_POST['price']);
$productCount = (int)($_POST['count']);
$userId = $_SESSION['user_id'];
$imgName = $_FILES['img']['name'];
$imgTmpName = $_FILES['img']['tmp_name'];
// Проверяю, не пусты ли эти переменные
if (empty($_FILES['img']) || !isset($prodactName) || !isset($description) || !isset($productPrice) || !isset($productCount) || !isset($userId)) {
    exit;
}
// Для наглядности запсос к БД тоже делаю переменной
$query = "insert into catalog (`name`, price, count, img, creator_id, description) values ('$prodactName', $productPrice, $productCount, '$imgName', $userId, '$description');";
// Выполняю запрос к БД
$result = mysqli_query($link, $query);
// Выключаем выполнение скрипта, если не удалось записать данные в БД (например, в моей БД настроена уникальность имен товаров)
if (!$result) {
    exit;
}
// Перемещаю картинку в директорию с изображениями
move_uploaded_file($imgTmpName, "../img/$imgName");
// Импортирую файл, отключающий от БД
include("../private/db_close.php");
