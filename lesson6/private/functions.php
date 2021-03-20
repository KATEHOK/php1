<?php

/**
 * функция генерирует рзметку для каталога
 * @param str $productLink путь до страницы продукта
 * @param str $wrapperClass класс обёртки
 * @param str $itemClass класс лэйблов элементов
 * @param str $imgClass класс изображения
 * @param str $emptyClass класс сообщения о пустоте
 * @param str $txtClass класс текстовых элементов
 * @param str $titleClass класс заголовка
 * @param str $infoClass класс инфо-обёртки
 * @param str $descriptionClass класс описания
 * @param str $alt текст alt-атрибута изображения
 */
function renderCatalog($isAdmin = false, $productLink = './private/product.php', $wrapperClass = 'catalog', $itemClass = 'catalog_item', $imgClass = 'pic_mini', $emptyClass = 'span_empty', $txtClass = 'catalog_item_txt', $titleClass = 'catalog_item_title', $infoClass = 'catalog_item_info', $descriptionClass = 'catalog_item_description', $alt = 'photo')
{
    if ($isAdmin) {
        $productLink = './private/product_admin.php';
    }
    include("./private/db_open.php");
    echo "<form action='$productLink' method='post' class='$wrapperClass'>";
    $query = mysqli_query($link, "select id, `name`, img, view, count, price, description from catalog order by view desc;");
    $isEmpty = true;
    while ($row = mysqli_fetch_assoc($query)) {
        echo "        
        <label class='$itemClass'>
            <input type='hidden' value='$isAdmin' name='is_admin'>
            <input type='submit' value='{$row['img']}' name='link' class='hide'>
            <p class='$txtClass $titleClass'>{$row['name']}</p>
            <img src='../img/{$row['img']}' alt='$alt' class='$imgClass'>
            <div class='$infoClass'>
                <p class='$txtClass'>Price: {$row['price']}</p>
                <p class='$txtClass'>Count: {$row['count']}</p>
                <p class='$txtClass'>Views: {$row['view']}</p>
            </div>
            <p class='$txtClass $descriptionClass'>{$row['description']}</p>
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
