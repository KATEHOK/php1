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
    <title>Galery</title>
    <link rel="stylesheet" href="style/main.css">
</head>

<body>
    <main class="main">
        <?php
        require_once('../engine/functions.php');
        renderGalery('../public/img/mini', 'img/mini/', 'img/'); // фунция в папке engine в файле function
        ?>
        <form method="post" enctype="multipart/form-data" class="form" action="../engine/upload/img.php">
            <input type="file" name="input_img" id="input-img" class="input input-file">
            <input type="submit" value="submit" class="input input-submit" name="submit_img">
        </form>
        <?php
        ?>
    </main>
</body>

</html>