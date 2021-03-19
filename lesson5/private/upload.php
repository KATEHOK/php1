<?php
// header("Location: ./add_product.php");
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

if (!((bool) $_POST['name']) || !((bool) $_POST['description']) || !((bool) $_FILES['img']['size'])) {
    header("Location: ./add_product.php");
}
var_dump($_FILES['img']);
echo '<br>';
var_dump($_POST);
