<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
require_once('../private/functions.php');
if (!isAdmin()) {
    header('Location: ../client/client.php');
    die;
}
header('Location: ./admin.php');
$productName = $_POST['name'];
$productId = $_POST['product_id'];
$price = $_POST['price'];
$count = $_POST['count'];
$description = $_POST['description'];
$userId = $_POST['user_id'];
include('../private/db_open.php');
$imgName = mysqli_fetch_assoc(mysqli_query($link, "select img from catalog where id = '$productId';"))['img'];
$query = "update catalog
set
    last_change = CURRENT_TIMESTAMP,
    name = '$productName',
    price = $price,
    count = $count,
    editor_id = $userId,
    description = '$description'";
if (!$_FILES['img']['name']) {
    $query = "$query where id = '$productId';";
    $haveImg = false;
} else {
    $haveImg = true;
    $newImgName = $_FILES['img']['name'];
    $imgTmpName = $_FILES['img']['tmp_name'];
    $query = "$query, img = '$newImgName' where id = '$productId';";
}
$result = mysqli_query($link, $query);
$imgCountChecker = mysqli_fetch_assoc(mysqli_query($link, "select count(img) as img_count from catalog where img = '$imgName';"))['img_count'] == 0;
if ($result && $imgCountChecker) {
    unlink("../img/$imgName");
}
if ($haveImg) {
    move_uploaded_file($imgTmpName, "../img/$newImgName");
}
include('../private/db_close.php');
