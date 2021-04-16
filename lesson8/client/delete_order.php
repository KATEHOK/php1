<?php
include('./user_filter.php');
header('Location: ./orders.php');
// если пользователь случайно забрел сюда, не нажав кнопку удаления, выпроваживаем его
if (!isset($_SESSION['last_order_id']) || !is_numeric($_SESSION['last_order_id'])) {
    die;
}
include('../private/db_open.php');
if (!$link) {
    die;
}
// в моей бд настроино удаление продуктов из order_products, если удалён соответствующий заказ
$query = "delete from `order` where id = '{$_SESSION['last_order_id']}';";
$result = mysqli_query($link, $query);
// если удаление из бд произошло успешно, удаляем элемент сессии
if ($result) {
    unset($_SESSION['last_order_id']);
}
include('../private/db_close.php');
