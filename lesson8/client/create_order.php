<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
// неавторизованных пользователей перенаправляем на авторизацию
session_start();
require_once('../private/functions.php');
if (!isset($_SESSION['user_id']) || isAdmin($_SESSION['user_id'])) {
    header('Location: ../');
    die;
}
if (!isset($_SESSION['user_cart'])) {
    header('Location: ./');
    die;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../style/main.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop</title>
</head>

<body>
    <main class="main">
        <a href="./" class="btn">Home</a>
        <form action="./pay.php" method="get" class="catalog">
            <fieldset class="add_product_wrapper">
                <label class="label">
                    <span class="catalog_item_txt">Your name</span>
                    <input type="text" name="user_name" class="add_product_input" placeholder="Василий Пупкин" required>
                </label>
                <label class="label">
                    <span class="catalog_item_txt">Your phone</span>
                    <input type="text" name="user_phone" class="add_product_input" placeholder="8(800)555-35-35" required>
                </label>
            </fieldset>
            <fieldset class="add_product_wrapper">
                <label class="label">
                    <span class="catalog_item_txt">Your wish</span>
                    <textarea name="user_wish" class="add_product_input textarea add_product_description" placeholder='Name me: "My Senior"...'></textarea>
                </label>
                <input type="submit" value="Pay" class="btn">
            </fieldset>
        </form>
    </main>
</body>

</html>