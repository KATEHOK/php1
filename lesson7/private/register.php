<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
include('./db_open.php');
// записываем переменные, применяя функции защиты
$userName = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['user_name']))));
$userLogin = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['login']))));
$userStatus = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['status']))));
$userPW = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['password']))));
// создаем хэш введенного пароля
$userPW = password_hash($userPW, PASSWORD_BCRYPT);
// проверка на подключение к бд и наличие данных
if (!$link || !$userName || !$userLogin || !$userPW) {
    header('Location: ../register.html'); // чего-либо нет - сброс, переадрессация
    die;
}
// определение статуса (в будущем реализую что-нибудь по типу промокода, но пока просто admin)
if ($userStatus == 'admin') {
    $userStatus = 1;
} else {
    $userStatus = 2;
}
// текст запроса
$query = "insert into users (name, login, pw_hash, status_id) values ('$userName', '$userLogin', '$userPW', $userStatus);";
// выполняем запрос
$result = mysqli_query($link, $query);
// закрываем бд
include('./db_close.php');
// переадрессация на индекс-станицу
header('Location: ../');
