<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
// неавторизованных пользователей перенаправляем на авторизацию
// Админам сюда нельзя
session_start();
require_once('../private/functions.php');
if (!isset($_SESSION['user_id']) || isAdmin($_SESSION['user_id'])) {
    header('Location: ../');
    die;
}
