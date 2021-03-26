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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop</title>
    <link rel="stylesheet" href="../style/main.css">
</head>

<body>
    <main class="main">
        <?php
        // подключаем файл с функциями и вызывем рендер-функцию (без параметра, потому что по умолчанию он false)
        require_once("../private/functions.php");
        renderCatalog();
        ?>
    </main>

</body>

</html>