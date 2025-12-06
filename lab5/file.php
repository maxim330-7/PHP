<?php
declare(strict_types=1);

const DB_FILE = __DIR__ . '/db/guestbook.txt';
const DB_DIR = __DIR__ . '/db';

/**
 * Сохраняет запись в гостевой книге
 * @param string $fname Имя пользователя
 * @param string $lname Фамилия пользователя
 * @return void
 */
function saveEntry(string $fname, string $lname): void {
    $entry = htmlspecialchars($fname) . ' ' . htmlspecialchars($lname) . "\n";
    
    if (!file_exists(DB_DIR)) {
        mkdir(DB_DIR, 0755, true);
    }
    
    file_put_contents(DB_FILE, $entry, FILE_APPEND);
}

/**
 * Получает все записи из гостевой книги
 * @return array<int, string>
 */
function getEntries(): array {
    if (!file_exists(DB_FILE)) {
        return [];
    }
    
    $content = file_get_contents(DB_FILE);
    if ($content === false) {
        return [];
    }
    
    $lines = explode("\n", trim($content));
    return array_filter($lines, fn($line) => !empty($line));
}

/**
 * Получает размер файла в байтах
 * @return int
 */
function getFileSize(): int {
    if (!file_exists(DB_FILE)) {
        return 0;
    }
    
    $size = filesize(DB_FILE);
    return $size === false ? 0 : $size;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = isset($_POST['fname']) ? (string)$_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? (string)$_POST['lname'] : '';
    
    $fname = trim(strip_tags($fname));
    $lname = trim(strip_tags($lname));
    
    if (!empty($fname) && !empty($lname)) {
        saveEntry($fname, $lname);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

$entries = getEntries();
$fileSize = getFileSize();
?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гостевая книга</title>
</head>
<body>
    <h1>Заполните форму</h1>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        Имя: <input type="text" name="fname"><br>
        Фамилия: <input type="text" name="lname"><br>
        <br>
        <input type="submit" value="Отправить!">
    </form>
    
    <hr>
    
    <?php foreach ($entries as $index => $entry): ?>
        <?php echo ($index + 1) . ' ' . htmlspecialchars($entry); ?><br>
    <?php endforeach; ?>
    
    <hr>
    Размер файла: <?php echo $fileSize; ?> байт
</body>
</html>

