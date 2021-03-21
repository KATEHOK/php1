<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
require_once('../private/functions.php');
if (!isAdmin()) {
    header('Location: ../client/client.php');
    die;
}
header('Location: ./admin.php');
include('../private/db_open.php');
// запоминаем имя картинки, получая его из бд по id
$imgName = mysqli_fetch_assoc(mysqli_query($link, "select img from catalog where id = {$_POST['id']};"))['img'];
// запоминаем результат выполнения запроса по удалению строки товара из бд
$result = mysqli_query($link, "delete from catalog where id = {$_POST['id']};");
// проверяем, остались ли товары с такой же картинкой в бд
$imgCountChecker = mysqli_fetch_assoc(mysqli_query($link, "select count(img) as img_count from catalog where img = '$imgName';"))['img_count'] == 0;
// если удаление из бд произошло успешно и в бд больше нет товаров с такой же картинкой, удаляем картинку из директории
if ($result && $imgCountChecker) {
    unlink("../img/$imgName");
}
include('../private/db_close.php');
