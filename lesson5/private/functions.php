<?php

/**
 * функция генерирует рзметку для галереи
 * @param str $way путь до директории с файлами, носящими корректные названия изображений
 * @param str $src_mini путь до директории с сжатыми копиями изображений
 * @param str $src путь до директории с оригинальными изображениями
 * @param str $wrapperClass класс обёртки галереи
 * @param str $itemClass класс ссылок-элементов галереи
 * @param str $imgClass класс изображения
 * @param str $emptyClass класс сообщения о пустоте галереи
 * @param str $alt текст alt-атрибута изображения
 */
function renderGalery($wrapperClass = 'gallery', $itemClass = 'gallery_item', $imgClass = 'pic_mini', $emptyClass = 'span_empty', $alt = 'photo')
{
    include("./private/db_open.php");
    echo "<form action='./private/full.php' method='post' class='$wrapperClass'>";

    $query = mysqli_query($link, "select id, `name`, view from pics order by view desc;");

    $isEmpty = true;

    while ($row = mysqli_fetch_assoc($query)) {
        echo "        
        <label class='gallery_item'>
            <input type='submit' value='{$row['name']}' name='link' class='hide'>
            <img src='../img/{$row['name']}' alt='photo' class='$imgClass'>
            <p class='gallery_item_txt'>Views: {$row['view']}</p>
        </label>";
        // var_dump($row);
        // echo '<br>';
        $isEmpty = false;
    }

    if (!$link) {
        echo "<span class='$emptyClass'>Не удалось подключиться к базе данных:(</span>";
    } elseif ($isEmpty) {
        echo "<span class='$emptyClass'>Галерея пуста:(</span>";
    }

    echo '</form>';
    include("./private/db_close.php");
}
