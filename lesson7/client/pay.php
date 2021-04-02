<?php
const strict_types = 1;
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
session_start();
require_once('../private/functions.php');
// неавторизованных пользователей перенаправляем на авторизацию,
// админа - на свою страничку
if (!isset($_SESSION['user_id']) || isAdmin($_SESSION['user_id'])) {
    header('Location: ../');
    die;
}
// если у юзера пустая корзина, отправляем его на слиент индекс
if (!isset($_SESSION['user_cart'])) {
    header('Location: ./');
    die;
}
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>MyShop</title>
    <link rel='stylesheet' href='../style/main.css'>
</head>

<body>
    <main class='main'>
        <a class='btn' href='./'>Home</a>
        <?php
        include('../private/db_open.php');
        // принимаем данные из формы, применяя функции защиты
        $user_name = mysqli_real_escape_string($link, htmlspecialchars(strip_tags(trim($_GET['user_name']))));
        $user_phone = mysqli_real_escape_string($link, htmlspecialchars(strip_tags(trim($_GET['user_phone']))));
        $user_wish = mysqli_real_escape_string($link, htmlspecialchars(strip_tags(trim($_GET['user_wish']))));
        // вспомогательная переменная
        $checker = true;
        // если связи с бд нет или поля ввода пусты, выводим соответствующее сообщение и прерываем скрипт
        if (!$link || !isset($user_name) || !isset($user_phone)) {
            echo "<span class='span_empty'>Input error or we lost connection with DB:(</span>
            </main></body></html>";
            die;
        }
        // создаем псевдослучайный id для заказа (не использую тут автоинкремент,
        // потому что далее при записи во вторую таблицу мне нужно знать id заказа)
        $order_id = time() + ((int) $user_phone);
        // запрос
        $query = "insert into `order` (id, user_name, user_phone, user_wish) values ('$order_id', '$user_name', '$user_phone', '$user_wish');";
        // выполняем
        $result = mysqli_query($link, $query);
        // ошибка? - соответствующее сообщение
        if (!$result) {
            echo "<span class='span_empty'>DB error:(</span>
            <span class='span_empty'>" . mysqli_error($link) . "</span>
            </main></body></html>";
            die;
        }
        // выполняем запрос о каждом товаре из сессии
        foreach ($_SESSION['user_cart'] as $product_id => $quantity) {
            $query = "insert into order_products (order_id, product_id, quantity) values ('$order_id', '$product_id', '$quantity');";
            $result = mysqli_query($link, $query);
            if (!$result) { // возникла ошибка - выводим сообщение
                echo "<span class='span_empty'>Ошибка записи продукта в БД</span>";
                $checker = false;
            }
        }
        // если все безупречно - сообщение
        if ($checker) {
            echo "<span class='span_empty'>Заказ создан успешно:)</span>";
            $_SESSION['user_cart'] = null;
            $query = "delete from cart where user_id = '{$_SESSION['user_id']}'";
            $result = mysqli_query($link, $query);
            if ($result) {
                echo "<span class='span_empty'>Корзина очищена</span>";
            }
        } else { // иначе - соответствующее сообщение
            echo "<span class='span_empty'>Заказ создан с ошибками:/</span>";
        }
        include('../private/db_close.php');
        ?>
    </main>
</body>

</html>