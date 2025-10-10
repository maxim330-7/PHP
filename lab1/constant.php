<?php
/*
ЗАДАНИЕ 1
- Создайте константу и присвойте ей значение.
*/
define("SITE_NAME", "Мой первый PHP-сайт");
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Константы</title>
</head>

<body>
    <h1>Константы</h1>
    <?php
	/*
	ЗАДАНИЕ 2
	- Проверьте, существует ли константа, которую Вы хотите использовать.
	- Выведите значение созданной константы.
	*/
	if (defined("SITE_NAME")) {
		echo "<p>Константа SITE_NAME существует и её значение: <strong>" . SITE_NAME . "</strong></p>";
	} else {
		echo "<p>Константа SITE_NAME не существует.</p>";
	}

	/*
	ЗАДАНИЕ 3
	- Используя предопределённые в ядре константы выведите текущую версию PHP.
	- Используя магические константы выведите директорию скрипта.
	*/
	echo "<p>Текущая версия PHP: <strong>" . PHP_VERSION . "</strong></p>";
	echo "<p>Директория скрипта: <strong>" . __DIR__ . "</strong></p>";
	?>
</body>

</html>