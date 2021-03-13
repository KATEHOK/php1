<!DOCTYPE html>
<html lang="en">

<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
?>

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
        renderGalery('../public/img/mini', 'img/mini/'); // фунция в папке engine в файле function
        ?>
        <!-- <form method="post"></form> -->
    </main>
</body>

</html>