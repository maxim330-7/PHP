<?php
declare(strict_types=1);


// Инициализация переменной для подсчета посещений
$visitCount = 0;

/**
 * Получает количество посещений из cookie
 * @return int Количество посещений
 */
function getVisitCountFromCookie(): int {
    if (isset($_COOKIE['visit_count'])) {
        return (int)trim(htmlspecialchars($_COOKIE['visit_count']));
    }
    return 0;
}

/**
 * Получает дату последнего посещения из cookie
 * @return string Дата последнего посещения
 */
function getLastVisitFromCookie(): string {
    if (isset($_COOKIE['last_visit'])) {
        return trim(htmlspecialchars($_COOKIE['last_visit']));
    }
    return '';
}

// Получаем данные из cookie
$visitCount = getVisitCountFromCookie();
$lastVisit = getLastVisitFromCookie();

// Увеличиваем счетчик посещений
$visitCount++;

// Устанавливаем текущее время для последнего посещения
$currentDateTime = date('d-m-Y H:i:s');

// Устанавливаем cookie на 1 сутки (86400 секунд)
setcookie('visit_count', (string)$visitCount, time() + 86400);
setcookie('last_visit', $currentDateTime, time() + 86400);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Последний визит</title>
</head>

<body>

    <h1>Последний визит</h1>

    <?php

function displayVisitInfo(int $visitCount, string $lastVisit): void {
    if ($visitCount === 1) {
        echo "<p>Добро пожаловать!</p>";
    } else {
        echo "<p>Вы зашли на страницу {$visitCount} раз</p>";
        if (!empty($lastVisit)) {
            echo "<p>Последнее посещение: {$lastVisit}</p>";
        }
    }
}

// Выводим информацию о посещениях
displayVisitInfo($visitCount, $lastVisit);
?>

</body>

</html>