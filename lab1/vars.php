<?php
/*
ЗАДАНИЕ 1
- Создайте переменную $name и присвойте ей значение содержащее Ваше имя, например 'Иван'(обязательно в одинарных кавычках!).
- Создайте переменную $age и присвойте ей значение содержащее Ваш возраст, например 20.
*/
$name = 'Максим';
$age = 20;

// ЗАДАНИЕ 2
// - Выведите с помощью echo фразу "Меня зовут: $name".
// - Выведите фразу "Мне $age лет".
// - Выведите информацию о типе переменных $name и $age.
// - Удалите переменные $name и $age.
// - Каждая фраза с новой строки.
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Переменные и вывод</title>
</head>

<body>
    <h1>Переменные и вывод</h1>

    <?php
	// Выводим данные
	echo "Меня зовут: $name<br>";
	echo "Мне $age лет<br>";
	echo "Тип переменной \$name: " . gettype($name) . "<br>";
	echo "Тип переменной \$age: " . gettype($age) . "<br>";

	// Удаляем переменные
	unset($name, $age);

	echo "Переменные удалены.";
	?>

</body>

</html>