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
function renderGalery($way, $src_mini, $src, $wrapperClass = 'galery', $itemClass = 'galery_item', $imgClass = 'pic_mini', $emptyClass = 'span_empty', $alt = 'photo')
{
    $imgs = scandir($way);
    echo "<div class='$wrapperClass'>";
    foreach ($imgs as $imgName) {
        if ($imgName != '.' && $imgName != '..') {
            echo "<a class='$itemClass' target='_blank' href='$src{$imgName}'><img class='$imgClass' src='$src_mini{$imgName}' alt='$alt'></a>";
        }
    }
    if (empty($imgs)) {
        echo "<span class='$emptyClass'>Галерея пуста:(</span>";
    }
    echo '</div>';
}
