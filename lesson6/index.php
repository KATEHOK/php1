<?php
require_once('./private/functions.php');
if (isAdmin()) {
    header("Location: ./admin/admin.php");
    die;
}
header('Location: ./client/client.php');
