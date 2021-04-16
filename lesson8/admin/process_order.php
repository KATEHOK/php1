<?php
require_once('./user_filter.php');
// var_dump($_POST);
foreach ($_POST as $key => $value) {
    if (is_array($value)) {
        foreach ($value as $k => $v) {
            echo "<br>==> KEY: $key($k); VALUE: $v;";
        }
    } else {
        echo "<br>KEY: $key; VALUE: $value;";
    }
}
