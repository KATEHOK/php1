<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
session_start();
// подключаем файл с функциями и выполняем проверку на статус
require_once('../private/functions.php');
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop (admin)</title>
    <link rel="stylesheet" href="../style/main.css">
</head>

<body>
    <main class="main">
        <?php
        // echo password_hash('noname', PASSWORD_BCRYPT);
        // echo '   ';
        // var_dump(password_verify('noname', ''));
        // вызываем рендер-функцию (параметр true - временный, потом буду получать инфу из сессии)
        renderCatalog();
        ?>
        <!-- тк это админка, добавляем кнопку добавления товара -->
        <a href="./add_product.php" class="btn">Добавить новый товар</a>
    </main>

</body>

</html>