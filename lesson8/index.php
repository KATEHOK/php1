<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
session_start();
// подключаем файл функций
require_once('./private/functions.php');
// проверяем статус пользователя и выполняем переадрессацию в соответствующую директорию
if (isset($_SESSION['user_id'])) {
    if (isAdmin($_SESSION['user_id'])) {
        header("Location: ./admin");
        die;
    }
    // если пользователь - клиент, то мы запускаем скрипт получения корзины из БД
    header('Location: ./client/get_cart_from_db.php');
    die;
}
header('Location: ./signin.html');
