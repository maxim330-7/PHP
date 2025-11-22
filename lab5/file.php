<?php
declare(strict_types=1);

/**
 * Гостевая книга с сохранением данных в текстовый файл
 */

const DATA_FILE = __DIR__ . '/db/guestbook.txt';

/**
 * Фильтрует и очищает входные данные
 * 
 * @param string $value Значение для фильтрации
 * @return string Очищенное значение
 */
function filterInput(string $value): string
{
    $value = trim($value);
    $value = strip_tags($value);
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Сохраняет данные пользователя в файл
 * 
 * @param string $fname Имя пользователя
 * @param string $lname Фамилия пользователя
 * @return bool true в случае успеха, false в случае ошибки
 */
function saveUserData(string $fname, string $lname): bool
{
    if (empty($fname) || empty($lname)) {
        return false;
    }
    
    $data = $fname . ' ' . $lname . PHP_EOL;
    
    $result = file_put_contents(DATA_FILE, $data, FILE_APPEND | LOCK_EX);
    return $result !== false;
}

/**
 * Получает все записи из гостевой книги
 * 
 * @return array Массив строк с записями пользователей
 */
function getAllEntries(): array
{
    if (!file_exists(DATA_FILE)) {
        return [];
    }
    
    $entries = file(DATA_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return $entries ?: [];
}

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = filterInput($_POST['fname'] ?? '');
    $lname = filterInput($_POST['lname'] ?? '');
    
    if (!empty($fname) && !empty($lname)) {
        saveUserData($fname, $lname);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

$entries = getAllEntries();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Работа с файлами</title>
</head>

<body>
    <h1>Заполните форму</h1>

    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        Имя: <input type="text" name="fname" required><br>
        Фамилия: <input type="text" name="lname" required><br>
        <br>
        <input type="submit" value="Отправить!">
    </form>

    <?php if (!empty($entries)): ?>
    <h2>Записи в гостевой книге:</h2>
    <?php foreach ($entries as $index => $entry): ?>
    <p><?= ($index + 1) . '. ' . $entry ?></p>
    <?php endforeach; ?>
    <p><strong>Размер файла:</strong> <?= file_exists(DATA_FILE) ? filesize(DATA_FILE) : 0 ?> байт</p>
    <?php endif; ?>
</body>

</html>