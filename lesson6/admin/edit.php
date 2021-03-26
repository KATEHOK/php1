<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
require_once('../private/functions.php');
// выполняем проверку статуса (подробней в admin/index.php)
if (!isAdmin()) {
    header('Location: ../client');
    die;
}
header('Location: ./');
// соединяемся с бд
include('../private/db_open.php');
// для наглядности создаем переменные, применяем функции защиты и удаления пробельных символов
$productName = mysqli_real_escape_string($link, htmlspecialchars(strip_tags(trim($_POST['name']))));
$productId = (int)($_POST['product_id']);
$price = (float)($_POST['price']);
$count = (int)($_POST['count']);
$description = mysqli_real_escape_string($link, htmlspecialchars(strip_tags(trim($_POST['description']))));
$userId = (int)($_POST['user_id']);
$imgName = mysqli_fetch_assoc(mysqli_query($link, "select img from catalog where id = '$productId';"))['img'];
// если хоть какое-то поле не было заполнено, завершаем скрипт
if (!$productName || !$productId || !$price || !$count || !$description || !$userId || !$imgName) {
    die;
}
// запрос на апдейт (для наглядности отформатировал)
$query = "update catalog
set
    last_change = CURRENT_TIMESTAMP,
    name = '$productName',
    price = $price,
    count = $count,
    editor_id = $userId,
    description = '$description'";
if (!$_FILES['img']['name']) {
    // если новая картинка не пришла, но не включаем в запрос ее добавление
    $query = "$query where id = '$productId';";
    $haveImg = false;
} else {
    // иначе - включаем и создаем переменные с временным именем и именем картинки
    $haveImg = true;
    $newImgName = $_FILES['img']['name'];
    $imgTmpName = $_FILES['img']['tmp_name'];
    $query = "$query, img = '$newImgName' where id = '$productId';";
}
// выполняем запрос, запоминаем в переменную результат
$result = mysqli_query($link, $query);
if (!$result) {
    die;
}
// выполняем запрос к бд, чтобы узнать, используется в других продуктах эта картинка
$imgCountChecker = mysqli_fetch_assoc(mysqli_query($link, "select count(img) as img_count from catalog where img = '$imgName';"))['img_count'] == 0;
// закрываем бд
include('../private/db_close.php');
if ($imgCountChecker) {
    // если в бд больше нет продуктов с такой же картинкой (которая была до обновления), удаляем ее из директории
    unlink("../img/$imgName");
}
if ($haveImg) {
    // если новая картинка была загружена, перемещаем ее в директорию
    move_uploaded_file($imgTmpName, "../img/$newImgName");
}
