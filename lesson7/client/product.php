<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
// неавторизованных пользователей перенаправляем на авторизацию
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../');
    die;
}
$idProduct = $_GET['id'];
// соединяемся с бд
include("../private/db_open.php");
// обновляем поле количества просмотров в бд
$updateView = mysqli_query($link, "update catalog set `view` = `view` + 1 where id = '$idProduct';");
// выполняем запрос к бд, получаем данные продукта по id, приводим к массиву, записываем его в переменную
$productObj = mysqli_query($link, "select name, img, description, view, count, price from catalog where id = '$idProduct';");
// если запрос не был выполнен, завершаем скрипт
if (!$productObj) {
    header('Location: ./');
    die;
}
$productObj = mysqli_fetch_assoc($productObj);
// закрываем бд
include('../private/db_close.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $productObj['name'] ?> MyShop</title>
    <link rel="stylesheet" href="../style/main.css">
</head>

<body>
    <main class='main_product'>
        <div class='main_product_wrapper'>
            <a href='./' class='btn back'>На главную</a>
            <div class='product_wrapper'>
                <a href='../img/<?= $productObj['img'] ?>' class='product_img_wrapper' target='_blank'><img src='../img/<?= $productObj['img'] ?>' class='product_img' alt='photo'></a>
                <form class='product_info catalog_item_info' method="get" action="./add_to_cart.php">
                    <span class='catalog_item_txt catalog_item_title'><?= $productObj['name'] ?></span>
                    <p class='catalog_item_txt catalog_item_description product_info_description'><?= $productObj['description'] ?></p>
                    <div class='product_info_wrapper'>
                        <span class='catalog_item_txt product_info_wrapper_item'>Price: <?= $productObj['price'] ?></span>
                        <span class='catalog_item_txt product_info_wrapper_item'>Count: <?= $productObj['count'] ?></span>
                        <span class='catalog_item_txt product_info_wrapper_item'>Views: <?= $productObj['view'] ?></span>
                    </div>
                    <input type="hidden" name="product_id" value="<?= $idProduct ?>">
                    <input type="submit" class="btn" value="Buy">
                </form>
            </div>
        </div>
    </main>
</body>

</html>