<?php
include('./user_filter.php');
// подключаем бд
include('../private/db_open.php');
// если соединение не было установлено, то мы предлагаем пользователю выбор либо выйти,
// либо все равно продолжить
if (!$link) {
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>MyShop</title>
        <link rel='stylesheet' href='../style/main.css'>
    </head>
    <body>
        <main class='main'>
            <span class='span_empty'>We lost connection with DB:(</span>
            <div class='btn_wrapper'>
                <a class='btn' href='./'>Всё равно продолжить (корзина будет пуста)</a>
                <a class='btn' href='../private/signout.php'>Sign out</a>
            </div>
        </main>
    </body>
    </html>";
    die;
}
// получаем данные из бд-корзины по id юзера
$query = "select product_id, quantity from cart where user_id = '{$_SESSION['user_id']}'";
$data = mysqli_query($link, $query);
while ($data_row = mysqli_fetch_assoc($data)) {
    // добавляем корзину в сессию
    $_SESSION['user_cart'][$data_row['product_id']] = $data_row['quantity'];
}
// закрываем бд
include('../private/db_close.php');
// перенаправляем на индекс-клиент
header('Location: ./');
