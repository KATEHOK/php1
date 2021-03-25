<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
// проверяю статус пользователя (подробнее в admin/index.php)
require_once('../private/functions.php');
if (!isAdmin()) {
    header('Location: ../client');
    die;
}
// переменные для удобства
$userId = $_POST['user_id'];
$idProduct = $_POST['id'];
// соединяемся с бд
include("../private/db_open.php");
// получаем данные из бд, преобразуем результат в объект
$productObj = mysqli_query($link, "select name, img, description, view, count, price from catalog where id = '$idProduct';");
// если запрос не был выполнен, завершаем скрипт
if (!$productObj) {
    header('Location: ./');
    die;
}
$productObj = mysqli_fetch_assoc($productObj);
// закрываем соединение с бд
include('../private/db_close.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $productObj['name'] ?> MyShop (admin)</title>
    <link rel="stylesheet" href="../style/main.css">
</head>

<body>
    <main class='main_product'>
        <div class='main_product_wrapper'>
            <a href='./' class='btn back'>На главную</a>
            <div class='product_wrapper'>
                <a href='../img/<?= $productObj['img'] ?>' class='product_img_wrapper' target='_blank'><img src='../img/<?= $productObj['img'] ?>' class='product_img' alt='photo'></a>
                <div class='product_info catalog_item_info'>
                    <span class='catalog_item_txt catalog_item_title'><?= $productObj['name'] ?></span>
                    <p class='catalog_item_txt catalog_item_description product_info_description'><?= $productObj['description'] ?></p>
                    <div class='product_info_wrapper'>
                        <span class='catalog_item_txt product_info_wrapper_item'>Price: <?= $productObj['price'] ?></span>
                        <span class='catalog_item_txt product_info_wrapper_item'>Count: <?= $productObj['count'] ?></span>
                        <span class='catalog_item_txt product_info_wrapper_item'>Views: <?= $productObj['view'] ?></span>
                    </div>
                    <div class="admin_controls">
                        <form action='./edit_product.php' method="post">
                            <input type="hidden" name="user_id" value="<?= $userId ?>">
                            <input type="hidden" name="id" value='<?= $idProduct ?>'>
                            <input type="submit" value="Редактировать" class="btn">
                        </form>
                        <form action='./delete.php' method="post">
                            <input type="hidden" name="id" value='<?= $idProduct ?>'>
                            <input type="submit" value="Удалить" class="btn">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>