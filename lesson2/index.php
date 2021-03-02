<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        const strict_types = 1;
        ini_set('error_reporting', (string)E_ALL);
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        const SITE_NAME = 'Lesson 2';
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME;?></title>
</head>
<body>
    <?php
    // 1
        $a = 30;
        $b = -2;
        if ($a >= 0 && $b >= 0) {
            echo abs($a - $b);
        } elseif ($a < 0 && $b < 0) {
            echo $a * $b;
        } elseif (($a >= 0) == ($b < 0)) {
            echo $a + $b;
        } else {
            echo 'Указаны неизвестные числа';
        }
    ?>
    <br>
    <?php
    // 2
        function echoAndIncrease(int $variable) {
            echo $variable++.' ';
            if ($variable <= 15) {
                echoAndIncrease($variable);
            }
        }
        $a = 9;
        // switch ($a) {
        //     case 0:
        //         echoAndIncrease(0);
        //     case 1:
        //         echoAndIncrease(1);
        //         break;
        //     case 2:
        //         echoAndIncrease(2);
        //         break;
        //     case 3:
        //         echoAndIncrease(3);
        //         break;
        //     case 4:
        //         echoAndIncrease(4);
        //         break;
        //     case 5:
        //         echoAndIncrease(5);
        //         break;
        //     case 6:
        //         echoAndIncrease(6);
        //         break;
        //     case 7:
        //         echoAndIncrease(7);
        //         break;
        //     case 8:
        //         echoAndIncrease(8);
        //         break;
        //     case 9:
        //         echoAndIncrease(9);
        //         break;
        //     case 10:
        //         echoAndIncrease(10);
        //         break;
        //     case 11:
        //         echoAndIncrease(11);
        //         break;
        //     case 12:
        //         echoAndIncrease(12);
        //         break;
        //     case 13:
        //         echoAndIncrease(13);
        //         break;
        //     case 14:
        //         echoAndIncrease(14);
        //         break;
        //     case 15:
        //         echoAndIncrease(15);
        //         break;
        // }
        // Не вижу смысла использовать switch, вполне оптимально:
        echoAndIncrease($a);
    ?>
    <br>
    <?php
    // 3
        function sum($a, $b) {
            return $a + $b;
        }
        function res($a, $b) {
            return $a - $b;
        }
        function mul($a, $b) {
            return $a * $b;
        }
        function div($a, $b) {
            return $a / $b;
        }
        echo sum(5, 6).", ".res(7, 3).", ".mul(2, 3).", ".div(9, 2);
    ?>
    <br>
    <?php
    // 4
        function mathOperation($arg1, $arg2, $operation) {
            switch ($operation) {
                case 'sum':
                    echo sum($arg1, $arg2);
                    break;
                case 'res':
                    echo res($arg1, $arg2);
                    break;
                case 'mul':
                    echo mul($arg1, $arg2);
                    break;
                case 'div':
                    echo div($arg1, $arg2);
                    break;
            }
        }
        echo mathOperation(5, 6, 'sum').", ";
        echo mathOperation(8, 6, 'res').", ";
        echo mathOperation(3, 6, 'mul').", ";
        echo mathOperation(5, 2, 'div');
    ?>
    <br>
    <?php
    // 5
        echo date("d.m.Y");
    ?>
    <br>
    <?php
    // 6
        function power($val, $pow, $first = null, $checker = true) {
            if ($val == 0 && $pow == 0) {
                return 'The value is not mathematically defined';
            } elseif ($val == 0) {
                return 0;
            } elseif ($val == 1) {
                return 1;
            } elseif ($pow == 0) {
                return 1;
            } elseif ($pow == 1) {
                return $val;
            } else {
                if ($checker) {
                    $first = $val;
                    $checker = false;
                }
                $val *= $first;
                $pow--;
                $result = power($val, $pow, $first, $checker);
            }
            return $result;
        }
        echo power(2, 10);
    ?>
    <br>
    <?php
    // 7
        $hour = ['ов', '', 'а', 'а', 'а', 'ов', 'ов', 'ов', 'ов', 'ов'];
        $minute = [ '', 'а', 'ы', 'ы', 'ы', '', '', '', '', '', ''];
        $time = date("H:i");
        $tens_h = (int) $time[0];
        $ones_h = (int) $time[1];
        $tens_m = (int) $time[3];
        $ones_m = (int) $time[4];
        if ($tens_h == 1) {
            $id_h = 0;
        } else {
            $id_h = $ones_h;
        }
        if ($tens_m == 1) {
            $id_m = 0;
        } else {
            $id_m = $ones_m;
        }
        echo "{$time} ===> {$tens_h}{$ones_h} час{$hour[$id_h]}, {$tens_m}{$ones_m} минут{$minute[$id_m]}";
    ?>
</body>
</html>