<?php
declare(strict_types=1);

$constants = get_defined_constants(true);
ksort($constants);
$total = array_sum(array_map('count', $constants));
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Константы PHP</title>
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

    .category {
        margin-bottom: 10px;
    }

    .category-header {
        background: #666;
        color: white;
        padding: 10px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        display: none;
    }

    .active table {
        display: table;
    }

    td,
    th {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .constant-name {
        color: #c00;
        font-family: monospace;
    }

    .constant-value {
        font-family: monospace;
        max-width: 300px;
        overflow: hidden;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Константы PHP (<?= $total ?>)</h1>

        <?php foreach ($constants as $category => $categoryConstants): ?>
        <div class="category">
            <div class="category-header" onclick="this.parentElement.classList.toggle('active')">
                <span><?= htmlspecialchars($category) ?></span>
                <span><?= count($categoryConstants) ?></span>
            </div>
            <table>
                <?php foreach ($categoryConstants as $name => $value): ?>
                <tr>
                    <td class="constant-name"><?= htmlspecialchars($name) ?></td>
                    <td class="constant-value"><?= 
                        is_bool($value) ? ($value ? 'true' : 'false') :
                        (is_null($value) ? 'null' :
                        (is_string($value) ? (strlen($value) > 50 ? 
                            "'".htmlspecialchars(substr($value, 0, 50))."..." : 
                            "'".htmlspecialchars($value)."'") : 
                        (is_array($value) ? 'array' : var_export($value, true))))
                    ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endforeach; ?>

        <div style="margin-top: 20px; color: #666; font-size: 0.9em;">
            PHP <?= PHP_VERSION ?> | <?= date('H:i:s') ?>
        </div>
    </div>
</body>

</html>