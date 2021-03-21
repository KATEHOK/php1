<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
// подключаем файл функций
require_once('./private/functions.php');
// проверяем статус пользователя и выполняем переадрессацию в соответствующую директорию
if (isAdmin()) {
    header("Location: ./admin");
    die;
}
header('Location: ./client');
