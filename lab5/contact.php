<?php
declare(strict_types=1);

/**
 * Форма обратной связи с отправкой email
 */

/**
 * Фильтрует и валидирует данные формы
 * 
 * @param array $postData Данные из формы
 * @return array Очищенные и проверенные данные
 */
function filterFormData(array $postData): array
{
    $subject = trim(strip_tags($postData['subject'] ?? ''));
    $body = trim(strip_tags($postData['body'] ?? ''));
    $email = filter_var($postData['email'] ?? '', FILTER_VALIDATE_EMAIL);
    
    return [
        'subject' => $subject,
        'body' => $body,
        'email' => $email
    ];
}

/**
 * Отправляет email с заданными параметрами
 * 
 * @param string $to Адрес получателя
 * @param string $subject Тема письма
 * @param string $body Текст письма
 * @param string $fromEmail Email отправителя
 * @return bool true если письмо отправлено успешно, false в противном случае
 */
function sendEmail(string $to, string $subject, string $body, string $fromEmail = 'admin@center.ogu'): bool
{
    $headers = [
        'From: ' . $fromEmail,
        'Reply-To: ' . $fromEmail,
        'X-Mailer: PHP/' . phpversion(),
        'Content-Type: text/plain; charset=UTF-8'
    ];
    
    $fullHeaders = implode("\r\n", $headers);
    
    return mail($to, $subject, $body, $fullHeaders);
}

// Обработка формы
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filteredData = filterFormData($_POST);
    
    if (empty($filteredData['subject']) || empty($filteredData['body']) || empty($filteredData['email'])) {
        $message = 'Пожалуйста, заполните все поля корректно';
        $messageType = 'error';
    } else {
        $to = 'max.shep444@gmail.com'; 
        $success = sendEmail($to, $filteredData['subject'], $filteredData['body']);
        
        if ($success) {
            $message = 'Сообщение успешно отправлено!';
            $messageType = 'success';
        } else {
            $message = 'Ошибка при отправке сообщения';
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обратная связь</title>
    <style>
    .success {
        color: green;
    }

    .error {
        color: red;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input,
    textarea {
        width: 300px;
        padding: 5px;
    }
    </style>
</head>

<body>
    <h1>Форма обратной связи</h1>

    <?php if (!empty($message)): ?>
    <p class="<?= $messageType ?>"><?= $message ?></p>
    <?php endif; ?>

    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        <div class="form-group">
            <label for="email">Ваш email:</label>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="subject">Тема:</label>
            <input type="text" id="subject" name="subject" required
                value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="body">Сообщение:</label>
            <textarea id="body" name="body" rows="5" required><?= 
                htmlspecialchars($_POST['body'] ?? '') 
            ?></textarea>
        </div>

        <button type="submit">Отправить</button>
    </form>
</body>

</html>
