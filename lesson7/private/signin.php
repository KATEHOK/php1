<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
session_start();
include('./db_open.php');
if (!isset($link)) { // Ошибка подключения? - сброс, переадрессация
    header('Location: ../');
    die;
}
// записываем в переменные, применяя функции защиты
$inputPW = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['password']))));
$inputLogin = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['login']))));
// выполняем запрос
$data = mysqli_query($link, "select id, pw_hash as hash from users where login = '$inputLogin';");
if (!$data) { // данные не получены? - сброс, переадрессация
    header('Location: ../');
    die;
}
// приводим к массиву
$data = mysqli_fetch_assoc($data);
// бд больше не нужна - закрываем
include('./db_close.php');
// проверяем пароль на соответствие хэшу
header('Location: ../');
if (password_verify($inputPW, $data['hash'])) {
    $_SESSION['user_id'] = $data['id']; // записываем в сессию id пользователя
}
die;
