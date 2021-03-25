<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
include('./db_open.php');
$userName = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['user_name']))));
$userLogin = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['login']))));
$userStatus = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['status']))));
$userPW = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['password']))));
$userPW = password_hash($userPW, PASSWORD_BCRYPT);
if (!$link || !$userName || !$userLogin || !$userPW) {
    header('Location: ../register.html');
    die;
}
if ($userStatus == 'admin') {
    $userStatus = 1;
} else {
    $userStatus = 2;
}
$query = "insert into users (name, login, pw_hash, status_id) values ('$userName', '$userLogin', '$userPW', $userStatus);";
$result = mysqli_query($link, $query);
include('./db_close.php');
header('Location: ../');
