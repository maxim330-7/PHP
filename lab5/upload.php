<?php
declare(strict_types=1);

/**
 * Обработка загрузки файлов на сервер
 */

const UPLOAD_DIR = __DIR__ . '/upload/';

/**
 * Создает директорию для загрузки, если она не существует
 * 
 * @param string $directory Путь к директории
 * @return bool true если директория существует или создана, false в случае ошибки
 */
function createUploadDirectory(string $directory): bool
{
    if (!is_dir($directory)) {
        return mkdir($directory, 0755, true);
    }
    return true;
}

/**
 * Проверяет, является ли файл изображением JPEG
 * 
 * @param string $tmpFilePath Путь к временному файлу
 * @return bool true если файл JPEG, false в противном случае
 */
function isJpegImage(string $tmpFilePath): bool
{
    if (!function_exists('mime_content_type')) {
        throw new RuntimeException('Модуль Fileinfo не установлен');
    }
    
    if (!file_exists($tmpFilePath)) {
        return false;
    }
    
    $mimeType = mime_content_type($tmpFilePath);
    return $mimeType === 'image/jpeg';
}

/**
 * Получает MIME-тип файла
 * 
 * @param string $filePath Путь к файлу
 * @return string MIME-тип файла или сообщение об ошибке
 */
function getMimeType(string $filePath): string
{
    if (!function_exists('mime_content_type')) {
        return 'Модуль Fileinfo не доступен';
    }
    
    if (!file_exists($filePath)) {
        return 'Файл не существует';
    }
    
    return mime_content_type($filePath);
}

/**
 * Обрабатывает загруженный файл
 * 
 * @param array $fileData Данные загруженного файла
 * @return array Результат обработки [success, message, mimeType]
 */
function handleUploadedFile(array $fileData): array
{
    if ($fileData['error'] !== UPLOAD_ERR_OK) {
        return [false, 'Ошибка загрузки файла: ' . $fileData['error'], ''];
    }
    
    // Создаем директорию для загрузки
    if (!createUploadDirectory(UPLOAD_DIR)) {
        return [false, 'Не удалось создать директорию для загрузки', ''];
    }
    
    // Получаем MIME-тип ДО проверки
    $mimeType = getMimeType($fileData['tmp_name']);
    
    // Проверяем тип файла
    if ($mimeType !== 'image/jpeg') {
        return [false, 'Разрешена загрузка только JPEG изображений. Ваш файл: ' . $mimeType, $mimeType];
    }
    
    // Генерируем имя файла на основе MD5 хеша
    $fileHash = md5_file($fileData['tmp_name']);
    $newFileName = $fileHash . '.jpg';
    $destination = UPLOAD_DIR . $newFileName;
    
    // Проверяем, не существует ли уже файл с таким именем
    if (file_exists($destination)) {
        return [true, 'Файл с таким содержимым уже существует: ' . $newFileName, $mimeType];
    }
    
    // Перемещаем загруженный файл
    if (move_uploaded_file($fileData['tmp_name'], $destination)) {
        // Устанавливаем правильные права на файл
        chmod($destination, 0644);
        return [true, 'Файл успешно загружен: ' . $newFileName, $mimeType];
    }
    
    return [false, 'Ошибка при сохранении файла. Проверьте права доступа к директории upload.', $mimeType];
}

// Обработка загрузки файла
$uploadResult = ['success' => false, 'message' => '', 'mimeType' => ''];
$fileInfo = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fupload'])) {
    $fileInfo = $_FILES['fupload'];
    
    if ($fileInfo['error'] === UPLOAD_ERR_OK) {
        // Сохраняем информацию о файле до обработки
        $fileInfoDetails = [
            'name' => htmlspecialchars($fileInfo['name']),
            'size' => $fileInfo['size'],
            'tmp_name' => $fileInfo['tmp_name'],
            'type' => $fileInfo['type'] ?? 'не определен',
            'error' => $fileInfo['error']
        ];
        
        // Получаем MIME-тип отдельно
        $mimeType = getMimeType($fileInfo['tmp_name']);
        $fileInfoDetails['mime_type'] = $mimeType;
        
        // Обрабатываем файл
        list($success, $message, $processedMimeType) = handleUploadedFile($fileInfo);
        $uploadResult = [
            'success' => $success,
            'message' => $message,
            'mimeType' => $processedMimeType ?: $mimeType
        ];
        
        // Обновляем MIME-тип в информации о файле
        $fileInfoDetails['mime_type'] = $uploadResult['mimeType'];
    } else {
        $uploadResult['message'] = 'Ошибка загрузки файла: ' . $fileInfo['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка файла на сервер</title>
</head>

<body>
    <h1>Загрузка файла на сервер</h1>

    <div class="info">
        <h3>Требования к загружаемому файлу:</h3>
        <ul>
            <li>Только JPEG изображения</li>
            <li>Максимальный размер: 10 МБ</li>
            <li>Файлы сохраняются с MD5-именем</li>
        </ul>

        <?php 
        // Проверяем доступность директории
        if (!is_dir(UPLOAD_DIR)) {
            echo '<p class="error">Директория upload не существует!</p>';
        } elseif (!is_writable(UPLOAD_DIR)) {
            echo '<p class="error">Директория upload недоступна для записи!</p>';
        } else {
            echo '<p class="success">Директория upload готова для загрузки файлов</p>';
        }
        ?>
    </div>

    <?php if (!empty($uploadResult['message'])): ?>
    <p class="<?= $uploadResult['success'] ? 'success' : 'error' ?>">
        <?= $uploadResult['message'] ?>
    </p>
    <?php endif; ?>

    <?php if (!empty($fileInfo) && $fileInfo['error'] === UPLOAD_ERR_OK): ?>
    <div class="file-info">
        <h3>Информация о загруженном файле:</h3>
        Имя файла: <?= $fileInfoDetails['name'] ?><br>
        Размер: <?= $fileInfoDetails['size'] ?> байт<br>
        Временный файл: <?= $fileInfoDetails['tmp_name'] ?><br>
        Тип (браузер): <?= $fileInfoDetails['type'] ?><br>
        MIME-тип (сервер): <?= $fileInfoDetails['mime_type'] ?><br>
        Код ошибки: <?= $fileInfoDetails['error'] ?><br>
    </div>
    <?php endif; ?>

    <form enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <p>
            <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
            <input type="file" name="fupload" accept="image/jpeg" required><br>
            <button type="submit">Загрузить</button>
        </p>
    </form>

</body>

</html>