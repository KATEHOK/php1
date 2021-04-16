<?php
require_once('./user_filter.php');
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
        // вызываем рендер-функцию (без параметров, потому что все нужные параметры установлены по умолчанию)
        renderCatalog();
        ?>
        <!-- тк это админка, добавляем кнопку добавления товара -->
        <a href="./add_product.php" class="btn">Добавить новый товар</a>
    </main>

</body>

</html>