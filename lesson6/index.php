<?php
$isAdmin = true; // пока что по умолчанию
if ($isAdmin) {
    header("Location: ./admin.php");
    die;
}
header('Location: ./client.php');
