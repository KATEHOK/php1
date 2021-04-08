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
            // если не пришел id, то выводим сообщение, завершаем скрипт
            if (!isset($_GET['order_id'])) {
                echo "
                <span class='span_empty'>Заказ не найден!</span>
                </div></main></body></html>";
                die;
            }
            // защита для числового типа данных
            $orderId = (int) $_GET['order_id'];
            // на случай удаления (чтоб не плодить формы)
            $_SESSION['last_order_id'] = $orderId;
            // связываемся с бд
            include('../private/db_open.php');
            // если связь не установилась, то выводим сообщение об ошибке и завершаем скрипт
            if (!$link) {
                echo "
                <span class='span_empty'>Ошибка связи с БД: " . mysqli_connect_error() . "</span>
                </div></main></body></html>";
                die;
            }
            // запрос на получение данных по каждому товару из заказа
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
            // если данные не получены, выводим сообщение, завершаем скрипт
            if (!$data) {
                echo "
                <span class='span_empty'>Не удалось получить данные заказа ID: $orderId</span>
                </div></main></body></html>";
                die;
            }
            // запрос на получение данных заказа (общих для всех товаров)
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
            // считаем общую стоимость
            $totalCoast = 0;
            // выводим инфу заказа
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
                // если заказ ещё не обработан, то его можно редактировать
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
                        <div class='btn_wrapper'>
                            <input type='submit' class='btn' value='Обновить'>
                            <a href='./delete_order.php' class='btn'>Удалить</a>
                        </div>
                    </form>";
            }
            // выводим список товаров заказа
            echo "<div class='catalog'>";
            while ($row = mysqli_fetch_assoc($data)) {
                // считаем полную стоимость товара и обновляем общую стоимость заказа
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
            // закрываем бд
            include('../private/db_close.php');
            ?>
            <span class='btn order_info'>Total coast: <?= $totalCoast ?></span>
        </div>
    </main>
</body>

</html>