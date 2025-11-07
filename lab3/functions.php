<?php
declare(strict_types=1);

$extensions = [];
foreach (get_loaded_extensions() as $extension) {
    $extensions[$extension] = get_extension_funcs($extension) ?: [];
}

$totalExtensions = count($extensions);
$totalFunctions = array_sum(array_map('count', $extensions));
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Модули PHP</title>
    <style>
    body {
        font-family: system-ui;
        margin: 20px;
        background: #f0f0f0;
    }

    .container {
        background: white;
        padding: 20px;
        border-radius: 8px;
    }

    .stats {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .stat {
        background: #666;
        color: white;
        padding: 10px;
        border-radius: 4px;
        text-align: center;
    }

    .extensions {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 15px;
    }

    .extension {
        background: #f8f8f8;
        padding: 15px;
        border-radius: 6px;
    }

    .extension-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .functions {
        max-height: 200px;
        overflow-y: auto;
        font-family: monospace;
        font-size: 0.9em;
    }

    .function {
        padding: 3px 0;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Модули PHP</h1>

        <div class="stats">
            <div class="stat">Модули: <?= $totalExtensions ?></div>
            <div class="stat">Функции: <?= $totalFunctions ?></div>
        </div>

        <div class="extensions">
            <?php foreach ($extensions as $name => $functions): ?>
            <div class="extension">
                <div class="extension-header">
                    <strong><?= htmlspecialchars($name) ?></strong>
                    <span><?= count($functions) ?></span>
                </div>
                <div class="functions">
                    <?php if ($functions): ?>
                    <?php sort($functions); ?>
                    <?php foreach ($functions as $function): ?>
                    <div class="function"><?= htmlspecialchars($function) ?></div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <div>Нет функций</div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>