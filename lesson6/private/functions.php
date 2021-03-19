<?php

/**
 * функция генерирует рзметку для каталога
 * @param str $productLink путь до страницы продукта
 * @param str $wrapperClass класс обёртки
 * @param str $itemClass класс лэйблов элементов
 * @param str $imgClass класс изображения
 * @param str $emptyClass класс сообщения о пустоте
 * @param str $txtClass класс текстовых элементов
 * @param str $alt текст alt-атрибута изображения
 */
function renderCatalog($productLink = './private/product.php', $wrapperClass = 'catalog', $itemClass = 'catalog_item', $imgClass = 'pic_mini', $emptyClass = 'span_empty', $txtClass = 'catalog_item_txt', $alt = 'photo')
{
    include("./private/db_open.php");
    echo "<form action='$productLink' method='post' class='$wrapperClass'>";
    $query = mysqli_query($link, "select id, `name`, img, view, count, price from catalog order by view desc;");
    $isEmpty = true;
    while ($row = mysqli_fetch_assoc($query)) {
        echo "        
        <label class='$itemClass'>
            <input type='submit' value='{$row['img']}' name='link' class='hide'>
            <img src='../img/{$row['img']}' alt='$alt' class='$imgClass'>
            <p class='$txtClass'>Views: {$row['view']}</p>
        </label>";

        $isEmpty = false;
    }
    if (!$link) {
        echo "<span class='$emptyClass'>Не удалось подключиться к базе данных:(</span>";
    } elseif ($isEmpty) {
        echo "<span class='$emptyClass'>В каталоге нет товаров:(</span>";
    }
    echo '</form>';
    include("./private/db_close.php");
}
