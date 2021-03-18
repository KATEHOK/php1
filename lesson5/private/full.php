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
    <main class="main_full">
        <div class="full_wrapper">
            <a href="/" class="back">Назад</a>
            <?php
            echo "<img src='../img/{$_POST['link']}' class='full_img' alt='photo'>";
            include("./db_open.php");
            $query = mysqli_query($link, "update pics set `view` = `view` + 1 where `name` = '{$_POST['link']}'");
            include('./db_close.php');
            ?>
        </div>

    </main>
</body>

</html>