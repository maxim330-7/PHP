<?php
$day = 6;
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Конструкция match</title>
</head>

<body>
    <h1>Конструкция match</h1>
    <?php

	$output = match ($day) {
		1, 2, 3, 4, 5 => "Это рабочий день",
		6, 7 => "Это выходной день",
		default => "Неизвестный день",
	};

	echo $output;
	?>
</body>

</html>
