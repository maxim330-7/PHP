<?php
declare(strict_types=1);

/**
 * Выводит каждый символ строки $var в столбик.
 *
 * @param string $var Строка, которую нужно вывести посимвольно.
 */
function printStringVertically(string $var): void {
    $length = strlen($var);
    $i = 0;
    while ($i < $length) {
        echo $var[$i] . '<br>';
        $i++;
    }
}

$var = 'ПРИВЕТ'; // Присваиваем строковое значение HELLO
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Цикл while</title>
</head>

<body>
    <h1>Цикл while</h1>
    <?php
	printStringVertically($var);
	?>
</body>


</html>
