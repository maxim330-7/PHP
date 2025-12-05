<?php
declare(strict_types=1);

function displayVisitedPages(): void {
    // Проверяем, существует ли массив посещенных страниц в сессии
    if (isset($_SESSION['visited_pages']) && !empty($_SESSION['visited_pages'])) {
        echo "<h3>Список посещённых страниц:</h3>";
        echo "<ul>";
        
        // Выводим все посещенные страницы в цикле
        foreach ($_SESSION['visited_pages'] as $index => $page) {
            $pageName = basename($page); // Получаем только имя файла
            echo "<li>" . ($index + 1) . ". $pageName</li>";
        }
        
        echo "</ul>";
    } else {
        echo "<p>Вы еще не посещали другие страницы.</p>";
    }
}

// Выводим список посещенных страниц
displayVisitedPages();
?>