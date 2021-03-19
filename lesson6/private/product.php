<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full image</title>
    <link rel="stylesheet" href="../style/main.css">
</head>

<body>
    <main class="main_product">
        <div class="product_wrapper">
            <a href="/" class="back">На главную</a>
            <?php
            echo "<img src='../img/{$_POST['link']}' class='product_img' alt='photo'>";
            include("./db_open.php");
            $query = mysqli_query($link, "update catalog set `view` = `view` + 1 where `img` = '{$_POST['link']}'");
            include('./db_close.php');
            ?>
        </div>

    </main>
</body>

</html>