<?php
// соединяемся с бд
$link = mysqli_connect("localhost", "root", "Kate_143090", "php1");
if (!$link) {
    // ошибка соединения? - покажи текст
    die(mysqli_connect_error($link));
}
