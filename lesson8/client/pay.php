<?php
include('./user_filter.php');
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
        $status_id = mysqli_fetch_assoc(mysqli_query($link, "select id from status where `name` = 'ordered'"))['id'];
        // запрос
        $query = "insert into `order` (user_id, user_name, user_phone, user_wish, order_status_id) values ('{$_SESSION['user_id']}', '$user_name', '$user_phone', '$user_wish', '$status_id');";
        // выполняем
        $result = mysqli_query($link, $query);
        // ошибка? - соответствующее сообщение
        if (!$result) {
            echo "<span class='span_empty'>DB error:(</span>
            <span class='span_empty'>" . mysqli_error($link) . "</span>
            </main></body></html>";
            die;
        }
        // получаем id только что записанных данных
        $order_id = mysqli_fetch_assoc(mysqli_query($link, "select id from `order` where user_phone = '$user_phone' order by id desc;"))['id'];
        // выполняем запрос о каждом товаре из сессии
        foreach ($_SESSION['user_cart'] as $product_id => $quantity) {
            $current_price = mysqli_fetch_assoc(mysqli_query($link, "select price from catalog where id = '$product_id';"))['price'];
            $query = "insert into order_products (order_id, product_id, quantity, current_price) values ('$order_id', '$product_id', '$quantity', '$current_price');";
            $result = mysqli_query($link, $query);
            if (!$result) { // возникла ошибка - выводим сообщение
                echo "<span class='span_empty'>Ошибка записи продукта в БД</span>";
                $checker = false;
            }
        }
        // если все безупречно - сообщение
        if ($checker) {
            echo "<span class='span_empty'>Заказ создан успешно:)</span>";
        } else { // иначе - соответствующее сообщение
            echo "<span class='span_empty'>Заказ создан с ошибками:/</span>";
        }
        // удаляем корзину из бд
        $query = "delete from cart where user_id = '{$_SESSION['user_id']}'";
        $result = mysqli_query($link, $query);
        if ($result) {
            unset($_SESSION['user_cart']);
            echo "<span class='span_empty'>Корзина очищена</span>";
        }
        include('../private/db_close.php');
        ?>
    </main>
</body>

</html>