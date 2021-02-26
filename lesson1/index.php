<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    const strict_types = 1;
    ini_set('error_reporting', (string)E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $a = 5;
    $b = '05';

    var_dump($a == $b);         // Почему true?
    /* Так как используется нестрогое стравнение,
    происходит неявное приведение строки '05' к числовому значению */

    var_dump((int)'012345');     // Почему 12345?
    /* Строка '012345' приводится к числовому типу,
    а числа не могут начинаться с 0, поэтому он отбрасывается */

    var_dump((float)123.0 === (int)123.0); // Почему false?
    /* Оператор строгого сравнения учитывает типы переменных,
    а разные типы не могут быть равны */

    var_dump((int)0 === (int)'hello, world'); // Почему true?
    /* При приведении строки, состоящей не из цифр, к числовому типу в итоге получается ноль,
    в итоге и значения и типы совпадают, строгое сравнение даст true
    (если бы строка начиналась с цифр, результат мог быть другим, например в результате (int) "098 флврфл";
    строка "098 флврфл" стала бы числом 98)
    (0 == 0, int == int => (int)0 === (int)'hello, world')
    */

    
    $a = 7897;
    $b =523598;
    [$a, $b] = [$b, $a];
    echo "<br>$a, $b";
    // Вывод: 523598, 7897
?>
</body>
</html>