<?php
require_once('./private/functions.php');
if (isAdmin()) {
    header("Location: ./admin");
    die;
}
header('Location: ./client');
