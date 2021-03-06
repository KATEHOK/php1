<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
// подключаем файл с функциями и выполняем проверку на статус
require_once('../private/functions.php');
if (!isAdmin()) {
    // не админ - будь добр, перейди на клиентскую версию
    header('Location: ../client');
    die;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop (admin)</title>
    <link rel="stylesheet" href="../style/main.css">
</head>

<body>
    <main class="main">
        <?php
        // вызываем рендер-функцию (параметр true - временный, потом буду получать инфу из сессии)
        renderCatalog(true);
        ?>
        <!-- тк это админка, добавляем кнопку добавления товара -->
        <form action='./add_product.php' method='post'>
            <input type='hidden' name='user_id' value='1'>
            <input type='submit' value='Добавить новый товар' class='btn'>
        </form>
        <!-- кнопка смены версии Админка => Клиентская -->
        <a href="../client">Клиентская</a>
    </main>

</body>

</html>