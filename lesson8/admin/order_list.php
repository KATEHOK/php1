<?php
require_once('./user_filter.php');
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
            // открываем БД
            include('../private/db_open.php');
            // связи нет - сообщение, стоп
            if (!$link) {
                echo "<span class='span_empty'>We lost connection with DB</span>
                </form></main></body></html>";
                die;
            }
            // количество заказов
            $len = mysqli_query($link, "select count(id) as counter from `order`;");
            // связи нет - сообщение, стоп
            if (!$len) {
                echo "<span class='span_empty'>DB ERROR: " . mysqli_error($link) . "</span>
                </form></main></body></html>";
                die;
            }
            $len = (int) mysqli_fetch_assoc($len)['counter'];
            // нет заказов - сообщение, стоп
            if ($len === 0) {
                echo "<span class='span_empty'>No orders</span>
                </form></main></body></html>";
                die;
            }
            // получаем данные о заказах
            $query = "
            select `order`.id as order_id, datetime, status.name as status_name
            from `order`
                inner join status on status.id = `order`.order_status_id
            order by datetime desc;";
            $data = mysqli_query($link, $query);
            // ошибка получения - сообщение, стоп
            if (!$data) {
                echo "<span class='span_empty'>DB ERROR: " . mysqli_error($link) . "</span>
                </form></main></body></html>";
                die;
            }
            // выводим краткую информацию о каждом из заказов
            while ($dataRow = mysqli_fetch_assoc($data)) {
                echo "
                <label class='catalog_item'>
                    <input type='submit' value='{$dataRow['order_id']}' name='order_id' class='hide'>
                    <p class='catalog_item_txt catalog_item_title'>Order ID: {$dataRow['order_id']}</p>
                    <p class='catalog_item_txt'>Ordered at: {$dataRow['datetime']}</p>
                    <p class='catalog_item_txt'>Order status: {$dataRow['status_name']}</p>
                </label>
                ";
            }
            // закрываем бд
            include('../private/db_close.php');
            ?>
        </form>
    </main>
</body>

</html>