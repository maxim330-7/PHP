<?php

function swap(&$a, &$b){
    $temp = $a;
    $a = $b;
    $b = $temp;
}

$a = 5;
$b = 8;

swap($a, $b);

echo '5 === $b: ', (5 === $b) ? 'true' : 'false';
echo "\n";
echo '8 === $a: ', (8 === $a) ? 'true' : 'false';
?>