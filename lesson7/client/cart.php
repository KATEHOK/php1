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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../style/main.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop Cart</title>
</head>

<body>
    <main class="main">
        <a href="./" class="btn">Home</a>
        <form action="./product.php" method="get" class="catalog">
            <?php
            // счетчик суммы
            $totalCoast = 0;
            // если корзина пуста, выводим сообщение
            if (!isset($_SESSION['user_cart'])) {
                echo "<span class='span_empty'>Cart is empty:(</span>";
                die;
            }
            // подключаем бд
            include('../private/db_open.php');
            // если соединения с бд нет, выводим сообщение
            if (!$link) {
                echo "<span class='span_empty'>Data lost:(</span>";
                die;
            }
            // перебираем циклом все товары корзины
            foreach ($_SESSION['user_cart'] as $productId => $productCount) {
                // выполняем запрос к бд
                $data = mysqli_query($link, "select name, img, view, price, description from catalog where id = '$productId';");
                // если произошла ошибка, переходим к следующей итерации
                if (!$data) {
                    continue;
                }
                // приводим данные из бд к массиву
                $data = mysqli_fetch_assoc($data);
                // считаем полную стоимость текущего товара
                $totalPrice = $productCount * $data['price'];
                // прибавляем ее к общей сумме
                $totalCoast += $totalPrice;
                // выводим инфу о продукте
                echo "
                <label class='catalog_item'>
                    <input type='submit' value='$productId' name='id' class='hide'>
                    <p class='catalog_item_txt catalog_item_title'>{$data['name']}</p>
                    <img src='../img/{$data['img']}' alt='photo' class='pic_mini'>
                    <p class='catalog_item_txt'>Single price: {$data['price']}</p>
                    <p class='catalog_item_txt'>Count in cart: $productCount</p>
                    <p class='catalog_item_txt'>Total price: $totalPrice</p>
                    <p class='catalog_item_txt catalog_item_description'>{$data['description']}</p>
                </label>";
            }
            // закрываем бд
            include('../private/db_close.php');
            // пока что корзина существует только в рамках сессии, то есть при выходе из учетки
            // корзина обнулится. В будущем реализую добавление данных в бд при выходе с учетки.
            ?>
        </form>
        <div class="btn_wrapper">
            <span class="catalog_item_txt">Total coast: <?= $totalCoast ?></span>
            <a href="#" class="btn">Pay</a>
        </div>
    </main>
</body>

</html>