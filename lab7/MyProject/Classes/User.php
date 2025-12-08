<?php
namespace MyProject\Classes;

class User {
      /**
     * Имя пользователя
     * @var string $name Полное имя пользователя
     * @access public
     */
    public $name;
    /**
     * Логин пользователя
     * @var string $login Логин пользователя
     * @access public
     */
    public $login;
     /**
     * Пароль пользователя
     * @var string $password Пароль пользователя
     * @access private
     */
    private $password;

     /**
     * Конструктор класса User
     * @param string $name Полное имя пользователя
     * @param string $login Логин пользователя 
     * @param string $password Пароль пользователя
     * 
     * @return void
     * @access public
     */
    public function __construct(string $name, string $login, string $password) {
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
        echo "Пользователь {$this->login} создан<br>";
    }

   /**
     * Метод для отображения информации о пользователе
     * @return void
     * @access public
     * 
     * @example
     * $user = new User("Максим Шепелев", "shepelev", "secret123");
     * $user->showInfo();
    
     */
    public function showInfo(): void {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px;'>";
        echo "<h3>Информация о пользователе:</h3>";
        echo "<p><strong>Имя:</strong> {$this->name}</p>";
        echo "<p><strong>Логин:</strong> {$this->login}</p>";
        echo "<p><strong>Пароль:</strong> ******</p>";
        echo "</div>";
    }

   /**
     * Деструктор класса User
     * @return void
     * @access public
     */
    public function __destruct() {
        echo "Пользователь {$this->login} удален<br>";
    }
}

?>
