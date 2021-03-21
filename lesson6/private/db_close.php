<?php
if ($link) {
    // если открыто соединение с бд - закрываем
    mysqli_close($link);
}
