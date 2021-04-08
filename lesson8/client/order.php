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
    <main class='main_product'>
        <div class='main_product_wrapper'>
            <a class='btn' href='./orders.php'>Your orders</a>
            <?php
            if (!isset($_GET['order_id'])) {
                echo "
                <span class='span_empty'>Заказ не найден!</span>
                </div></main></body></html>";
                die;
            }
            $orderId = (int) $_GET['order_id'];
            include('../private/db_open.php');
            if (!$link) {
                echo "
                <span class='span_empty'>Ошибка связи с БД: " . mysqli_connect_error() . "</span>
                </div></main></body></html>";
                die;
            }
            $query = "
            select
                order_products.quantity as product_quantity,
                current_price,
                catalog.name as product_name,
                img,
                description
            from `order`
                inner join order_products on order_products.order_id = `order`.id
                inner join catalog on order_products.product_id = catalog.id
                where `order`.id = $orderId;";
            $data = mysqli_query($link, $query);
            if (!$data) {
                echo "
                <span class='span_empty'>Не удалось получить данные заказа ID: $orderId</span>
                </div></main></body></html>";
                die;
            }
            $query = "
            select
                `order`.id as order_id,
                user_name,
                user_phone,
                datetime,
                user_wish,
                status.name as status_name
            from status
                inner join `order` on `order`.order_status_id = status.id
                where `order`.id = $orderId;";
            $orderData = mysqli_fetch_assoc(mysqli_query($link, $query));
            $totalCoast = 0;
            if ($orderData['status_name'] != 'ordered') {
                echo "
                    <div class='catalog_item order_info'>
                        <p class='catalog_item_txt'>Order ID: {$orderData['order_id']}</p>
                        <p class='catalog_item_txt'>Datetime: {$orderData['datetime']}</p>
                        <p class='catalog_item_txt'>Status: {$orderData['status_name']}</p>
                        <p class='catalog_item_txt'>Your name: {$orderData['user_name']}</p>
                        <p class='catalog_item_txt'>Your phone: {$orderData['user_phone']}</p>
                        <p class='catalog_item_txt'>Your wish: {$orderData['user_wish']}</p>
                    </div>";
            } else {
                echo "
                    <script defer src='../js/can_update_order.js'></script>
                    <form id='form' method='get' action='./update_order.php' class='catalog_item order_info'>
                        <p class='catalog_item_txt'>Order ID: {$orderData['order_id']}</p>
                        <p class='catalog_item_txt'>Datetime: {$orderData['datetime']}</p>
                        <p class='catalog_item_txt'>Status: {$orderData['status_name']}</p>
                        <label class='label add_product_item'>
                            <span class='label_span'>Your name</span>
                            <input id='user_name' class='add_product_input' type='text' class='catalog_item_txt' value='{$orderData['user_name']}' required>
                        </label>
                        <label class='label add_product_item'>
                            <span class='label_span'>Your phone</span>
                            <input id='user_phone' class='add_product_input' type='text' class='catalog_item_txt' value='{$orderData['user_phone']}' required>
                        </label>
                        <label class='label add_product_item'>
                            <span class='label_span'>Your wish</span>
                            <textarea id='user_wish' class='textarea add_product_input add_product_description' class='catalog_item_txt'>{$orderData['user_wish']}</textarea>
                        </label>
                        <input type='submit' class='btn' value='Обновить'>
                    </form>";
            }
            echo "<div class='catalog'>";
            while ($row = mysqli_fetch_assoc($data)) {
                $totalPrice = $row['current_price'] * $row['product_quantity'];
                $totalCoast += $totalPrice;
                echo "
                    <div class='catalog_item order_info'>
                        <p class='catalog_item_txt catalog_item_title'>{$row['product_name']}</p>
                        <img src='../img/{$row['img']}' alt='photo' class='pic_mini'>
                        <p class='catalog_item_txt'>Single price: {$row['current_price']}</p>
                        <p class='catalog_item_txt'>Count in cart: {$row['product_quantity']}</p>
                        <p class='catalog_item_txt'>Total price: $totalPrice</p>
                        <p class='catalog_item_txt catalog_item_description'>{$row['description']}</p>
                    </div>";
            }
            echo "</div>";
            var_dump($orderData['status_name']);
            include('../private/db_close.php');
            ?>
            <span class='btn order_info'>Total coast: <?= $totalCoast ?></span>
        </div>
    </main>
</body>

</html>