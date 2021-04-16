<?php
require_once('./user_filter.php');
// без пропуска - идешь выбирать заказ
if (!isset($_SESSION['check_cart'])) {
    header('Location: ./order_list.php');
    die;
}
// обнуляем пропуск
unset($_SESSION['check_cart']);
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
        <div class="btn_wrapper">
            <a href="./order_list.php" class="btn">Back</a>
            <a href="./" class="btn">Home</a>
        </div>
        <?php
        // переменные для удобства
        $orderStatus = $_POST['status_radio'];
        $userPhone = $_POST['user_phone'];
        $product_array = $_POST['product_id'];
        $quantity_array = $_POST['product_quantity'];
        $orderId = $_POST['order_id'];
        // подключаем бд
        include('../private/db_open.php');
        if (!$link) {
            echo "<span class='span_empty'>DB ERROR: " . mysqli_connect_error($link) . "</span>
        </main></body></html>";
            die;
        }
        // массив для данных из бд
        $db_data = [];
        // получаем из бд каличество продуктов на складе
        foreach ($product_array as $id) {
            $query = "
            select
                `count`
            from catalog
            where id = '$id'";
            $result = mysqli_query($link, $query);
            if (!$result) {
                echo "<span class='span_empty'>DB ERROR: " . mysqli_error($link) . "</span>
                </main></body></html>";
                die;
            }
            $db_data[$id] = mysqli_fetch_assoc($result)['count'];
        }
        // вспомогательная переменная
        $status = true;
        // перезаписываем количество каждого заказанного товара
        foreach ($product_array as $idId => $valueId) {
            // новое количество = количество из бд минус заказанное количество
            $newCount = $db_data[$valueId] - $quantity_array[$idId];
            $query = "
            update catalog
            set
                `count` = '$newCount'
            where id = '$valueId'";
            $result = mysqli_query($link, $query);
            if (!$result) {
                $status = false;
            }
        }
        // если ошибок не было, получаем id статуса
        // (тк в POST мы получаем наименование, а в моей таблице заказов фигурирует только id статуса)
        if ($status) {
            $query = "
            select
                id
            from status
            where name = '$orderStatus'";
            $newStatusId = mysqli_query($link, $query);
            if ($newStatusId) {
                $newStatusId = mysqli_fetch_assoc($newStatusId)['id'];
            } else {
                $status = false;
            }
        }
        // если ранее ошибок не было, то обновляем id статуса заказа и номер телефона
        if ($status) {
            $query = "
            update `order`
            set
                order_status_id = '$newStatusId',
                user_phone = '$userPhone'
            where id = '$orderId'";
            $result = mysqli_query($link, $query);
            if (!$result) {
                $status = false;
            } else {
                echo "<span class='span_empty'>Заказ обработан безошибочно!</span>";
            }
        }
        // если возникла хоть одна ошибка, выводим соответствующее сообщение
        if (!$status) {
            echo "<span class='span_empty'>Заказ обработан с ошибками! Необходимо исправить ошибки вручную!</span>";
        }
        // закрываем бд
        include('../private/db_close.php');
        ?>
    </main>
</body>

</html>