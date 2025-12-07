<?php
// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Фильтрация данных
    $subject = trim($_POST['subject'] ?? '');
    $body = trim($_POST['body'] ?? '');
    
    // Проверка заполненности полей
    if (!empty($subject) && !empty($body)) {
        $to = 'max.shep444@gmail.com';
        $headers = "From: admin@center.ogu\r\n";
        $headers .= "Reply-To: admin@center.ogu\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        // Отправка письма
        if (mail($to, $subject, $body, $headers)) {
            $message = 'Сообщение успешно отправлено!';
            $messageType = 'success';
        } else {
            $message = 'Ошибка при отправке сообщения';
            $messageType = 'error';
        }
    } else {
        $message = 'Пожалуйста, заполните все поля';
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обратная связь</title>
    <style>
        .success { color: green; }
        .error { color: red; }
        label { display: block; margin-bottom: 5px; }
        input, textarea { padding: 5px; }
    </style>
</head>
<body>
    <!-- Область основного контента -->
    <h3>Адрес</h3>
    <address>123456 Москва, Малый Американский переулок 21</address>
    
    <?php if (isset($message)): ?>
    <p class="<?= $messageType ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    
    <h3>Задайте вопрос</h3>
    <form action='' method='post'>
        <label>Тема письма: </label>
        <br>
        <input name='subject' type='text' size="50" 
               value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>">
        <br>
        <label>Содержание: </label>
        <br>
        <textarea name='body' cols="50" rows="10"><?= 
            htmlspecialchars($_POST['body'] ?? '') 
        ?></textarea>
        <br>
        <br>
        <input type='submit' value='Отправить'>
    </form>
    <!-- Область основного контента -->
</body>
</html>
