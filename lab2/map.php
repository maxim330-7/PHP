<?php

function map(array $array, callable $callback): array
{
    $result = [];
    
    foreach ($array as $index => $value) {
        $result[$index] = $callback($value, $index);
    }
    
    return $result;
}

$numbers = [1, 2, 3, 4, 5];
$squaredNumbers = map($numbers, fn($num) => $num ** 2);

echo "Исходный массив: " . implode(', ', $numbers) . "\n";
echo "Квадраты чисел: " . implode(', ', $squaredNumbers) . "\n";
$result = map($numbers, fn($num, $index) => "Индекс $index: " . ($num ** 2));

echo "\nРезультат с индексами:\n";
print_r($result);