<?php
require_once('./user_filter.php');
if (!isset($_GET['order_id'])) {
    header('Location: ./order_list.php');
    die;
}
$orderId = (int) $_GET['order_id'];
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
            <a href="./" class="btn">Home</a>
            <a href="./order_list.php" class="btn">Back</a>
        </div>
        <!-- Использую post, чтобы застраховаться от "корректировки" пользователем имени статуса (тк они заданы по умолчанию) -->
        <form action="./process_order.php" method="post" class="catalog admin_order" id='form'>
            <?php
            // подкдлючаем бд
            include('../private/db_open.php');
            // получаем количество товаров
            $query = "select count(product_id) as counter from order_products where order_id = '$orderId';";
            $len = mysqli_query($link, $query);
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
            // запрос на получение названий статусов
            $query = "
            select
                status.name as status_name
            from status
                inner join `order` on `order`.order_status_id = status.id
            where `order`.id = '$orderId';";
            $statusName = mysqli_query($link, $query);
            // ошибка - сообщение
            if (!$statusName) {
                echo "<span class='span_empty'>DB Error: " . mysqli_error($link) . "</span>
                </form></main></body></html>";
                die;
            }
            $statusName = mysqli_fetch_assoc($statusName)['status_name'];
            // буду записывать в переменную разметку
            $template = "
            <fieldset class='admin_order_item'>
                <fieldset class='register_fieldset status_list admin_order_item_item'>
                    <span class='catalog_item_txt'>Order&nbsp;status</span>
                    <label class='btn radio_label'>
                        <input type='radio' name='status_radio' value='ordered' class='hide radio_input'";
            // если в бд текущий статус - checked (далее не комментирую этот момент)
            if ($statusName == 'ordered') {
                $template = $template . "checked";
            }
            // дописываем разметку
            $template = $template . ">
                        <span class='label_span radio_span'>ordered</span>
                    </label>
                    <label class='btn radio_label'>
                        <input type='radio' name='status_radio' value='sent' class='hide radio_input'";
            if ($statusName == 'sent') {
                $template = $template . "checked";
            }
            $template = $template . ">
                        <span class='label_span radio_span'>sent</span>
                    </label>
                    <label class='btn radio_label'>
                        <input type='radio' name='status_radio' value='canceled' class='hide radio_input'";
            if ($statusName == 'canceled') {
                $template = $template . "checked";
            }
            $template = $template . ">
                        <span class='label_span radio_span'>canceled</span>
                    </label>
                </fieldset>";
            // запрос на получение общих данных заказа
            $query = "
            select
                user_name,
                datetime,
                user_wish,
                user_phone
            from `order`
            where `order`.id = $orderId";
            $data = mysqli_query($link, $query);
            // ошибка - сообщение
            if (!$data) {
                echo "<span class='span_empty'>DB Error: " . mysqli_error($link) . "</span>
                </form></main></body></html>";
                die;
            }
            $data = mysqli_fetch_assoc($data);
            // дописываем разметку, используя полученные данные
            $template = $template . "
            <fieldset class='register_fieldset status_list admin_order_item_item'>
                <label class='label'>
                    <span class='catalog_item_txt'>Clients name</span>
                    <p class='add_product_input'>{$data['user_name']}</p>
                </label>
                <label class='label'>
                    <span class='catalog_item_txt'>Clients phone</span>
                    <input type='text' id='user_phone' value='{$data['user_phone']}' name='user_phone' class='add_product_input'
                        placeholder='8(800)555-35-35' required>
                </label>
                <label class='label'>
                    <span class='catalog_item_txt'>Clients wish</span>
                    <p class='add_product_input'>{$data['user_wish']}</p>
                </label>
            </fieldset>
            </fieldset>";
            // запрос на получение данных о каждом продукте заказа
            $query = "
            select
                quantity,
                catalog.id as product_id,
                catalog.count as count_in_base
            from catalog
                inner join order_products on order_products.product_id = catalog.id
            where order_id = $orderId;";
            $data = mysqli_query($link, $query);
            // ошибка - сообщение
            if (!$data) {
                echo "<span class='span_empty'>DB Error: " . mysqli_error($link) . "</span>
                </form></main></body></html>";
                die;
            }
            // дописываем в разметку данные о продуктах
            $template = $template . "
            <fieldset class='admin_order_item'>";
            $status = true;
            while ($dataRow = mysqli_fetch_assoc($data)) {
                $quantity = $dataRow['quantity'];
                $countInBase = $dataRow['count_in_base'];
                $classRed = '';
                // если количество товаров на складе меньше количества заказанных, создаем класс цвета текста
                if ($quantity > $countInBase) {
                    $status = false;
                    $classRed = ' red_txt';
                }
                // если нужно, вписываем класс
                $template = $template . "
                <div class='admin_order_item_product'>
                    <span class='catalog_item_txt'>Product ID: {$dataRow['product_id']}</span>
                    <span class='catalog_item_txt$classRed'>Quantity: $quantity</span>
                    <span class='catalog_item_txt$classRed'>Count in base: $countInBase</span>
                    <input type='hidden' name='product_id[]' value='{$dataRow['product_id']}'>
                </div>";
            }
            $template = $template . "</fieldset>
            <input type='hidden' name='order_id' value='$orderId'>";
            // если в предыдущем цикле внезапно хоть одна ошибка, е выводим настоящей кнопки
            if ($status) {
                $template = $template . "<input type='submit' value='Применить' class='btn'>";
            } else {
                $template = $template . "<span class='btn'>Применить</span>";
            }
            // выводим разметку (использую переменную, чтобы в случае возникновения 
            // ошибки на промежуточном этапе получения данных не выводить никакой информации о заказе)
            echo $template;
            // закрываем бд
            include('../private/db_close.php');
            ?>
        </form>
    </main>
</body>

</html>