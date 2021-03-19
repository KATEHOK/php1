<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
$isAdmin = true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop<?php if ($isAdmin) {
                        echo " (admin)";
                    } ?></title>
    <link rel="stylesheet" href="style/main.css">
</head>

<body>
    <main class="main">
        <?php
        require_once("./private/functions.php");
        renderCatalog();
        if ($isAdmin) {
            // На этапе разработки по умолчанию $isAdmin = true
            echo "
            <form action='./private/add_product.php' method='post'>
                <input type='hidden' name='user_id' value='1'>
                <input type='submit' value='Добавить новый товар' class='btn'>
            </form>";
        }
        ?>
    </main>

</body>

</html>