<?php
declare(strict_types=1);

function initializeDateTimeVariables(): array
{
    $now = time();
    
    $currentYear = (int)date('Y');
    $birthday = mktime(0, 0, 0, 3, 12, $currentYear);
    
    if ($birthday < $now) {
        $birthday = mktime(0, 0, 0, 3, 12, date('Y') + 1);
    }
    
    $currentDate = getdate();
    $hour = $currentDate['hours'];
    
    return [
        'now' => $now,
        'birthday' => $birthday,
        'hour' => $hour
    ];
}

function getWelcomeMessage(int $hour): string
{
    if ($hour >= 6 && $hour < 12) {
        return 'Доброе утро';
    } elseif ($hour >= 12 && $hour < 18) {
        return 'Добрый день';
    } elseif ($hour >= 18 && $hour < 23) {
        return 'Добрый вечер';
    } else {
        return 'Доброй ночи';
    }
}

function formatRussianDate(int $timestamp): string
{
    $fmt = datefmt_create(
        'ru_RU',
        IntlDateFormatter::FULL,
        IntlDateFormatter::MEDIUM,
        'Europe/Moscow',
        IntlDateFormatter::GREGORIAN,
        "Сегодня d MMMM Y 'года', EEEE H:mm:ss"
    );
    
    return datefmt_format($fmt, $timestamp);
}

function getTimeUntilBirthday(int $now, int $birthday): array
{
    $secondsLeft = $birthday - $now;
    
    $days = floor($secondsLeft / (60 * 60 * 24));
    $hours = floor(($secondsLeft % (60 * 60 * 24)) / (60 * 60));
    $minutes = floor(($secondsLeft % (60 * 60)) / 60);
    $seconds = $secondsLeft % 60;
    
    return [
        'days' => $days,
        'hours' => $hours,
        'minutes' => $minutes,
        'seconds' => $seconds
    ];
}

$data = initializeDateTimeVariables();
$now = $data['now'];
$birthday = $data['birthday'];
$hour = $data['hour'];

$welcome = getWelcomeMessage($hour);

$formattedDate = formatRussianDate($now);

$timeUntilBirthday = getTimeUntilBirthday($now, $birthday);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Использование функций даты и времени</title>
</head>

<body>
    <h1>Использование функций даты и времени</h1>

    <div class="welcome"><?= $welcome ?></div>

    <div class="date-info">
        <strong>Текущая дата и время:</strong><br>
        <?= $formattedDate ?>
    </div>

    <div class="birthday-info">
        <strong>До моего дня рождения осталось:</strong><br>
        <?= $timeUntilBirthday['days'] ?> дней,
        <?= $timeUntilBirthday['hours'] ?> часов,
        <?= $timeUntilBirthday['minutes'] ?> минут,
        <?= $timeUntilBirthday['seconds'] ?> секунд
    </div>
</body>

</html>