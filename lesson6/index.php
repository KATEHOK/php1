<?php
require_once('./private/functions.php');
if (isAdmin()) {
    header("Location: ./admin.php");
    die;
}
header('Location: ./client.php');
