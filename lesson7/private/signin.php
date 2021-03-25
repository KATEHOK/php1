<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
session_start();
include('./db_open.php');
if (!isset($link)) {
    header('Location: ../');
    die;
}
$inputPW = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['password']))));
$inputLogin = trim(mysqli_real_escape_string($link, htmlspecialchars(strip_tags($_POST['login']))));
$data = mysqli_query($link, "select id, pw_hash as hash from users where login = '$inputLogin';");
// root -> root; noname -> noname (login -> pw)
if (!$data) {
    header('Location: ../');
    die;
}
$data = mysqli_fetch_assoc($data);
include('./db_close.php');
if (password_verify($inputPW, $data['hash'])) {
    $_SESSION['user_id'] = $data['id'];
    header('Location: ../');
} else {
    header('Location: ../');
    die;
}
