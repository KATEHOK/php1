<?php
include('./user_filter.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../style/main.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop</title>
</head>

<body>
    <main class="main">
        <a href="./" class="btn">Home</a>
        <form action="./order.php" method="get" class="catalog">
            <?php
            include('../private/db_open.php');
            // если связи с бд нет или поля ввода пусты, выводим соответствующее сообщение и прерываем скрипт
            if (!$link) {
                echo "<span class='span_empty'>We lost connection with DB:(</span>
                </form></main></body></html>";
                die;
            }
            // получаем количество заказов пользователя и в случае их отсутствия выводим соответствующее сообщение
            $query = "select count(id) as counter from `order` where user_id = '{$_SESSION['user_id']}';";
            $result = mysqli_fetch_assoc(mysqli_query($link, $query))['counter'];
            if (!$result) {
                echo "<span class='span_empty'>You have not orders in DB:(</span>
                </form></main></body></html>";
                die;
            }
            // получаем данные о заказах пользователя
            $query = "select `order`.id as order_id, datetime, user_phone, user_wish, status.`name` as status_name from `order`
                    inner join status on status.id = `order`.order_status_id
                    where user_id = '{$_SESSION['user_id']}';";
            $data = mysqli_query($link, $query);
            // выводим заказы
            while ($row = mysqli_fetch_assoc($data)) {
                echo "
                <label class='label catalog_item'>
                    <input type='submit' value='{$row['order_id']}' name='order_id' class='hide'>
                    <p class='catalog_item_txt'>Order ID: {$row['order_id']}</p>
                    <p class='catalog_item_txt'>Datetime: {$row['datetime']}</p>
                    <p class='catalog_item_txt'>Your phone: {$row['user_phone']}</p>
                    <p class='catalog_item_txt'>Your wish: {$row['user_wish']}</p>
                    <p class='catalog_item_txt'>Status: {$row['status_name']}</p>
                </label>";
            }
            ?>
        </form>
    </main>
</body>

</html>