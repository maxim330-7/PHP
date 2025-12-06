<?php
declare(strict_types=1);

/**
 * Автозагрузчик классов
 * @param string $className Полное имя класса 
 * @return void
 */
spl_autoload_register(function ($className) {
    // Преобразуем пространство имен в путь к файлу
    $filePath = str_replace('MyProject\\Classes\\', 'MyProject/Classes/', $className) . '.php';
    
    if (file_exists($filePath)) {
        require_once $filePath;
        return true;
    }
    return false;
});

use MyProject\Classes\User;
use MyProject\Classes\SuperUser;

echo "<h1>Демонстрация работы с классами</h1>";

echo "<h2>Обычные пользователи:</h2>";
$user1 = new User("Грек Макбыков", "makbykov", "password123");
$user2 = new User("Владимир Путин", "putin", "qwerty123");
$user3 = new User("Максим Шепелев", "shepelev", "secret123");
$user1->showInfo();
$user2->showInfo();
$user3->showInfo();

echo "<h2>Суперпользователь:</h2>";
$superUser = new SuperUser("Администратор", "admin", "admin123", "Супер-администратор");
$superUser->showInfo();

echo "<p>Скрипт завершен. Объекты будут уничтожены автоматически.</p>";

?>
