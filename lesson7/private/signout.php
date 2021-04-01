<?php
session_start();
require_once('./functions.php');
// далее перед сбросом сессии для клиентов обновляем бд-корзину
if (isset($_SESSION['user_cart'])) {
    // соединяемся с бд
    include('./db_open.php');
    if (!$link) {
        // ошибка соединения - сброс скрипта, переадрессация
        header('Location: ../client');
        die;
    }
    // вспомогательный запрос: вернет строку 0, если в бд-корзине у данного юзера нет товаров
    $query = "select count(product_id) as product_count from cart where user_id = {$_SESSION['user_id']};";
    $result = mysqli_fetch_assoc(mysqli_query($link, $query))['product_count'];
    // если у него есть товары, то удаляем их из бд
    if ($result !== '0') {
        $query = "delete from cart where user_id = '{$_SESSION['user_id']}'";
        mysqli_query($link, $query);
    }
    // заполняем бд-корзину товарами из сессиии
    foreach ($_SESSION['user_cart'] as $product_id => $quantity) {
        $query = "insert into cart (user_id, product_id, quantity) values ('{$_SESSION['user_id']}', '$product_id', '$quantity')";
        mysqli_query($link, $query);
    }
    // закрываем бд
    include('./db_close.php');
}
// сбрасываем сессию
session_destroy();
// переадрессация
header('Location: ../');
