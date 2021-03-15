<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
header("Location: ../../public"); // Переадрессация на главную страницу

// для удобства создал переменные
$file_tmp_name = $_FILES['input_img']['tmp_name'];
$file_name = $_FILES['input_img']['name'];
$uploaded_name = "../../public/img/$file_name";
$name_for_mini = "../../public/img/mini/$file_name";

// если форма не пуста, выполняем сохранение файла
if (!empty($_POST['submit_img'])) {
    var_dump(move_uploaded_file($file_tmp_name, $uploaded_name));
    // Пока не разобрался, как сжать фото, поэтому пока что копирую без изменений
    copy($uploaded_name, $name_for_mini);
}
