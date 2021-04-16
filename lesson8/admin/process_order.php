<?php
require_once('./user_filter.php');
// без пропуска - идешь выбирать заказ
if (!isset($_SESSION['check_cart'])) {
    header('Location: ./order_list.php');
    die;
}
// обнуляем пропуск
unset($_SESSION['check_cart']);
foreach ($_POST as $key => $value) {
    if (is_array($value)) {
        foreach ($value as $k => $v) {
            echo "<br>==> KEY: $key($k); VALUE: $v;";
        }
    } else {
        echo "<br>KEY: $key; VALUE: $value;";
    }
}
