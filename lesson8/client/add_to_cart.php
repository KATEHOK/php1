<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
// неавторизованных пользователей перенаправляем на авторизацию
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../');
    die;
}
header('Location: ./');
// получаем id продукта
$productId = $_GET['product_id'];
if (isset($_SESSION['user_cart'])) { // если в сессии уже есть корзина
    if (isset($_SESSION['user_cart'][$productId])) { // если в корзине уже есть такой товар
        $_SESSION['user_cart'][$productId]++; // увеличиваем его количество
    } else {
        $_SESSION['user_cart'][$productId] = 1; // если такого товара не было в корзине, создаём его с количеством 1
    }
} else { // если в сессии не было корзины, создаем ее и помещаем в нее текущий товар с количеством 1
    $_SESSION['user_cart'][$productId] = 1;
}
