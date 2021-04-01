<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
session_start();
// подключаем файл с функциями и выполняем проверку на статус
require_once('../private/functions.php');
// неавторизованных пользователей перенаправляем на индекс-файл сайта
if (!isset($_SESSION['user_id'])) {
    header('Location: ../');
    die;
}
if (!isAdmin($_SESSION['user_id'])) {
    // не админ - будь добр, перейди на клиентскую версию
    header('Location: ../client');
    die;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script defer src="../js/add_img.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/main.css">
    <title>MyShop (admin)</title>
</head>

<body>
    <main class="main">
        <a href="../" class="btn">На главную</a>
        <form method="post" enctype="multipart/form-data" class="add_product catalog" action="./upload.php">
            <fieldset class="add_product_wrapper">
                <label class="label add_product_item">
                    <span class="label_span">Название товара</span>
                    <input type="text" name="name" placeholder="Картофан" class="input add_product_input" required>
                </label>
                <label class="label add_product_item">
                    <span class="label_span">Цена товара</span>
                    <input type="text" name="price" class="add_product_input" placeholder="10000" required>
                </label>
                <label class="label add_product_item">
                    <span class="label_span">Количество товара</span>
                    <input type="text" name="count" class="add_product_input" placeholder="30" required>
                </label>
                <label class="label add_product_img add_product_item">
                    <span id="selected-file" class="label_span add_product_input_file_name">Файл не выбран</span>
                    <span class="btn add_product_input_file_btn" id='select-img-btn'>Выбрать изображение</span>
                    <input id="input-file" type="file" name="img" class="add_product_input_file" class="input_file" required>
                </label>
                <input type="submit" value="Загрузить" class="btn add_product_submit add_product_item" name="submit_btn">
            </fieldset>
            <label class="label">
                <span class="label_span">Описание товара</span>
                <textarea name="description" cols="40" rows="15" class="textarea add_product_input add_product_description" placeholder="Блаблабла..." required></textarea>
            </label>
        </form>
    </main>

</body>

</html>