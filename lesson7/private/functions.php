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
function renderCatalog($method = 'get', $productLink = './product.php', $wrapperClass = 'catalog', $itemClass = 'catalog_item', $imgClass = 'pic_mini', $emptyClass = 'span_empty', $txtClass = 'catalog_item_txt', $titleClass = 'catalog_item_title', $infoClass = 'catalog_item_info', $descriptionClass = 'catalog_item_description', $alt = 'photo')
{
    echo "<a class='btn' href='../private/signout.php'>Sign out</a>";
    // пути к файлам с открытием и закрытием бд идентичны для обеих версий страницы, поэтому просто импортируем их
    include('../private/db_open.php');
    // выполняем запрос к бд для получения информации о продуктах каталога
    $query = mysqli_query($link, "select id, name, img, view, count, price, description from catalog order by view desc;");
    // всопомогательная переменная (если в каталоге не окажется товаров, то мы выведем соответствующее сообщение)
    $isEmpty = true;
    // выводим открывающий тэг формы (класс и ссылку на файл-обработчик берем из аргументов функции)
    echo "<form action='$productLink' method='$method' class='$wrapperClass'>";
    // запускаем цикл: пока мы принимаем объект, выводим товар на страницу
    while ($row = mysqli_fetch_assoc($query)) {
        echo "        
        <label class='$itemClass'>
            <input type='submit' value='{$row['id']}' name='id' class='hide'>
            <p class='$txtClass $titleClass'>{$row['name']}</p>
            <img src='../img/{$row['img']}' alt='$alt' class='$imgClass'>
            <div class='$infoClass'>
                <p class='$txtClass'>Price: {$row['price']}</p>
                <p class='$txtClass'>Count: {$row['count']}</p>
                <p class='$txtClass'>Views: {$row['view']}</p>
            </div>
            <p class='$txtClass $descriptionClass'>{$row['description']}</p>
        </label>";
        // если хоть один раз выполнилось тело цикла, меняем значение вспомогательной переменной
        $isEmpty = false;
    }
    if (!$link) {
        // если не произошло соединения с бд, выводим соответствующее сообщение
        echo "<span class='$emptyClass'>Не удалось подключиться к базе данных:(</span>";
    } elseif ($isEmpty) {
        // если каталог не содержит товаров, выводим соответствующее сообщение
        echo "<span class='$emptyClass'>В каталоге нет товаров:(</span>";
    }
    // закрываем тэг формы
    echo '</form>';
    // закрываем соединение с бд
    include('../private/db_close.php');
}
/**
 * функция проверяет, является ли пользователь админом
 * @param int $id id пользователя (сейчас по умолчанию 1)
 * (в моей бд пользователь с индексом 1 является админом)
 * (в следующей работе буду получать индекс из сессии)
 */
function isAdmin($id = 1)
{
    // устонавливаю соединение с бд вручную,
    // потому что функция будет использоваться в файлах,
    // в которых путь относительно bd_open.php будет разным
    // (по этой же причине ниже вручную отключаюсь от бд)
    $link = mysqli_connect("localhost", "root", "Kate_143090", "php1");
    if (!$link) {
        return false;
    }
    // соединяю две таблицы из бд: таблицу пользователей и таблицу статусов
    // (статусы вынес в отдельную таблицу, чтобы в будущем иметь возможность изменять их)
    // выбираю из соединённых таблиц имя статуса строчки с id, который передавался в качестве параметра
    $query = "select status.name as status_name from users
	            inner join status on status.id = users.status_id
                where users.id = $id;";
    // выполняю запрос, результат привожу к массиву, выбираю интересующий меня элемент
    $answer = mysqli_fetch_assoc(mysqli_query($link, $query))['status_name'];
    mysqli_close($link);
    // возвращаю true, если имя статуса совпадает с нужным (admin)
    return $answer == 'admin';
}
