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
    <link rel="stylesheet" href="../style/main.css">
    <title>AddProduct</title>
</head>

<body>

    <main class="main">
        <a href="../index.php" class="back">На главную</a>
        <form method="post" enctype="multipart/form-data" class="add_product gallery" action="./upload.php">
            <fieldset class="add_product_wrapper">
                <label class="label">
                    <span class="label_span">Название товара</span>
                    <input type="text" name="name" placeholder="Картофан" class="input add_product_name">
                </label>

                <label class="label add_product_img">
                    <span class="label_span">Выберите изображение товара</span>
                    <input type="file" name="img" class="input_file" class="input_file">
                </label>

                <input type="submit" value="Загрузить" class="btn add_product_submit" name="submit_btn">
            </fieldset>

            <label class="label">
                <span class="label_span">Описание товара</span>
                <textarea name="description" cols="30" rows="10" class="textarea add_product_description" placeholder="Блаблабла..."></textarea>
            </label>
        </form>
    </main>

</body>

</html>