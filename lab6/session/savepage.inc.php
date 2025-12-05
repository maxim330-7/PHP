<?php
declare(strict_types=1);

function saveVisitedPage(string $pagePath): void {
    // Инициализируем массив посещенных страниц, если его нет
    if (!isset($_SESSION['visited_pages'])) {
        $_SESSION['visited_pages'] = [];
    }
    
    $_SESSION['visited_pages'][] = $pagePath;
}

// Получаем текущий путь страницы
$currentPage = $_SERVER['PHP_SELF'];
saveVisitedPage($currentPage);
?>