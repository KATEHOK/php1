<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
$isAdmin = true; // на этапе разработки по умолчанию true
if (!$isAdmin) {
    header('Location: ../client.php');
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
    <main class="main_product">
        <div class="product_wrapper">
            <a href="/" class="btn">На главную</a>
            <?php
            echo "<a href='../img/{$_POST['link']}' target='_blank'><img src='../img/{$_POST['link']}' class='product_img' alt='photo'></a>";
            ?>
        </div>

    </main>
</body>

</html>