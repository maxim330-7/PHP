<?php
namespace MyProject\Classes;

class SuperUser extends User {
     /**
     * Роль суперпользователя в системе
     * @var string $role Роль пользователя в системе
     * @access public
     */
    public $role;

    /**
     * Конструктор SuperUser
     * @param string $name Полное имя суперпользователя
     * @param string $login Логин суперпользователя
     * @param string $password Пароль суперпользователя
     * @param string $role Роль суперпользователя в системе
     * 
     * @return void
     * @access public
     * 
     * @uses User::__construct() Для инициализации базовых свойств
     */
    public function __construct(string $name, string $login, string $password, string $role) {
        parent::__construct($name, $login, $password);
        $this->role = $role;
    }

   /**
     * Переопределенный метод для отображения информации о суперпользователе
     * 
     * Выводит расширенную информацию о суперпользователе,
     * включая его роль. 
     * @return void
     * @access public
     * @override
     * 
     * @see User::showInfo() 
     * 
     * @example
     * $admin = new SuperUser("Админ", "admin", "pass123", "Главный администратор");
     * $admin->showInfo();
     * // Выведет информацию с указанием роли пользователя
     */
    public function showInfo(): void {
        echo "<div style='border: 3px solid #f00; padding: 10px; margin: 10px; background: #FFD700;'>";
        echo "<h3>Информация о СУПЕРпользователе:</h3>";
        echo "<p><strong>Имя:</strong> {$this->name}</p>";
        echo "<p><strong>Логин:</strong> {$this->login}</p>";
        echo "<p><strong>Пароль:</strong> ******</p>";
        echo "<p><strong>Роль:</strong> {$this->role}</p>";
        echo "</div>";
    }
}

?>
