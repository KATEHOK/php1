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
    <title>Lesson 3</title>
</head>

<body>
    <?php
    echo "---------------------------1---------------------------------<br>";
    $counter = 1;
    while ($counter <= 100) {
        if ($counter % 3 == 0) {
            echo "$counter ";
        }
        if ($counter % 15 == 0) {
            echo "<br>";
        }
        $counter++;
    }
    echo "<br>---------------------------2---------------------------------<br>";
    function is_even($num)
    {
        return $num % 2 == 0;
    }
    $counter = 0;
    do {
        if ($counter == 0) {
            $text = "ноль";
        } elseif (is_even($counter)) {
            $text = "чётное число";
        } else {
            $text = "нечётное число";
        }
        echo "$counter - $text<br>";
        $counter++;
    } while ($counter <= 10);
    echo "---------------------------3---------------------------------<br>";
    $areas = [
        "Московская область" => ["Москва", "Краснознаменск", "Одинцово", "Зеленоград"],
        "Ленинградская область" => ["Санкт-Петербург", "Гатчина", "Выборг", "Каменногорск"],
        "Саратовская область" => ["Саратов", "Пугачёв", "Новоузенск"],
        "Ростовская область" => ["Ростов-на-Дону", "Азов", "Каменск-Шахтинский"],
    ];
    foreach ($areas as $area => $cities) {
        echo $area . ":<br>" . implode(", ", $cities) . "<br>";
    };
    echo "---------------------------4---------------------------------<br>";
    function str_split_utf8($str)
    {
        $split = 1;
        $array = array();
        for ($i = 0; $i < strlen($str);) {
            $value = ord($str[$i]);
            if ($value > 127) {
                if ($value >= 192 && $value <= 223)      $split = 2;
                elseif ($value >= 224 && $value <= 239)  $split = 3;
                elseif ($value >= 240 && $value <= 247)  $split = 4;
            } else $split = 1;
            $key = NULL;
            for ($j = 0; $j < $split; $j++, $i++) $key .= $str[$i];
            array_push($array, $key);
        }
        return $array;
    }
    const DICT = ['а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => "sh'", 'ъ' => '^', 'ы' => 'i', 'ь' => "'", 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'Ts', 'Ч' => 'CH', 'Ш' => 'Sh', 'Щ' => "Sh'", 'Ъ' => '^', 'Ы' => 'I', 'Ь' => "'", 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya'];
    function translateMessage($message)
    {
        $result = '';
        // $letters = str_split($message); // после выполнения метода слетает кодировка,
        // русские буквы не распознаются и отображаются как вопросики...
        $letters = str_split_utf8($message); // нашел на одном из форумов такой аналог
        // mb_str_split() - нашел в мануале, но при использовании выскакивает ошибка: Fatal error: Uncaught Error: Call to undefined function mb_str_split()
        // var_dump($letters);
        foreach ($letters as &$letter) {
            if (isset(DICT[$letter])) {
                $result = $result . DICT[$letter];
            } else {
                $result = $result . $letter;
            }
        };
        return $result;
    }
    $text = "Почти каждый день у меня подъём в 7 часов утра.";
    echo "$text => " . translateMessage($text);
    echo "<br>---------------------------5---------------------------------<br>";
    function replacer($message)
    {
        return str_replace(' ', '_', $message);
    }
    echo replacer('Утром было солнечно и совсем тепло...');
    echo "<br>---------------------------6---------------------------------<br>";
    echo '<a href="https://github.com/KATEHOK/php1/tree/main/main" target="_blank">Директория с проектом</a>';
    echo "<br>---------------------------7---------------------------------<br>";
    for ($counter = 0; $counter < 10; var_dump($counter++)) {
    }
    echo "<br>---------------------------8---------------------------------<br>";
    foreach ($areas as $area => $cities) {
        echo "$area:<br>";
        $array = [];
        foreach ($cities as $city) {
            if (str_split_utf8($city)[0] == 'К') {
                $array[] = $city;
            }
        };
        if ($array) {
            echo implode(', ', $array) . '<br>';
        } else {
            echo '(Нет городов на букву К)<br>';
        }
    };
    echo "---------------------------9---------------------------------<br>";
    function superTranslator($message)
    {
        return replacer(translateMessage($message));
    }
    $message = 'Больше всего на свете я люблю кушать пельмешки:)';
    echo "$message => " . superTranslator($message);
    ?>
</body>

</html>