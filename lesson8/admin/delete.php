<?php
require_once('./user_filter.php');
header('Location: ./');
// подключаем бд
include('../private/db_open.php');
// запоминаем имя картинки, получая его из бд по id
$imgName = mysqli_fetch_assoc(mysqli_query($link, "select img from catalog where id = {$_POST['id']};"))['img'];
// запоминаем результат выполнения запроса по удалению строки товара из бд
$result = mysqli_query($link, "delete from catalog where id = {$_POST['id']};");
if (!$result) {
    die;
}
// проверяем, остались ли товары с такой же картинкой в бд
$imgCountChecker = mysqli_fetch_assoc(mysqli_query($link, "select count(img) as img_count from catalog where img = '$imgName';"))['img_count'] == 0;
// если в бд больше нет товаров с такой же картинкой, удаляем картинку из директории
if ($imgCountChecker) {
    unlink("../img/$imgName");
}
// отключаем бд
include('../private/db_close.php');
