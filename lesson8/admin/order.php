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
        <form action="./change_order.php" method="post">
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
                echo "<span class='span_empty'>No products</span>
                </form></main></body></html>";
                die;
            }
            $query = "
            select status.name as status_name from status
                inner join `order` on `order`.order_status_id = status.id
            where `order`.id = '$orderId';";
            $statusName = mysqli_fetch_assoc(mysqli_query($link, $query))['status_name'];
            ?>
            <fieldset class="btn_wrapper register_fieldset">
                <legend>Order status</legend>
                <label class="btn radio_label">
                    <input type="radio" name="status_radio" class="hide radio_input" <?php if ($statusName == 'ordered') echo "checked"; ?>>
                    <span class="label_span radio_span">ordered</span>
                </label>
                <label class="btn radio_label">
                    <input type="radio" name="status_radio" class="hide radio_input" <?php if ($statusName == 'sent') echo "checked"; ?>>
                    <span class="label_span radio_span">sent</span>
                </label>
                <label class="btn radio_label">
                    <input type="radio" name="status_radio" class="hide radio_input" <?php if ($statusName == 'canceled') echo "checked"; ?>>
                    <span class="label_span radio_span">canceled</span>
                </label>
            </fieldset>
            <?php
            // Проект не доделан!
            // закрываем бд
            include('../private/db_close.php');
            ?>
        </form>
    </main>
</body>

</html>