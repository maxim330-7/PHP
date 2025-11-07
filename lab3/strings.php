<?php
declare(strict_types=1);

$login = ' User ';
$password = 'megaP@ssw0rd';
$name = 'иван';
$email = 'ivan@petrov.ru';
$code = '<?=$login?>';
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Использование функций обработки строк</title>
</head>

<body>

    <?php
	$login = trim($login);
	$login = strtolower($login);
	echo "Обработанный логин: '$login'<br>";
	
	function checkPasswordStrength(string $password): bool {
		if (strlen($password) < 8) {
			return false;
		}
		
		if (!preg_match('/[A-Z]/', $password)) {
			return false;
		}
		
		if (!preg_match('/[a-z]/', $password)) {
			return false;
		}
		
		if (!preg_match('/[0-9]/', $password)) {
			return false;
		}
		
		return true;
	}
	
	$isPasswordStrong = checkPasswordStrength($password);
	echo "Пароль сложный: " . ($isPasswordStrong ? 'да' : 'нет') . "<br>";
	
	$name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
	echo "Обработанное имя: $name<br>";
	
	$isEmailValid = filter_var($email, FILTER_VALIDATE_EMAIL);
	echo "Email корректный: " . ($isEmailValid ? 'да' : 'нет') . "<br>";
	
	echo "Код: " . htmlspecialchars($code) . "<br>";
?>
</body>

</html>