<?php
include('./user_filter.php');
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
