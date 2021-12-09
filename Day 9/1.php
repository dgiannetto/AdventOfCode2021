<?php

$file = fopen('input.txt', 'r');

$heightMap = [];
while ($line = fgets($file)) {
    $line = str_split(trim($line));
    $heightMap[] = $line;
}

$riskSum = 0;
foreach ($heightMap as $i => $row) {
    foreach ($row as $j => $height) {
        if (isset($heightMap[$i-1][$j]) && $heightMap[$i-1][$j] <= $height) {
            continue;
        }
        if (isset($heightMap[$i+1][$j]) && $heightMap[$i+1][$j] <= $height) {
            continue;
        }
        if (isset($heightMap[$i][$j-1]) && $heightMap[$i][$j-1] <= $height) {
            continue;
        }
        if (isset($heightMap[$i][$j+1]) && $heightMap[$i][$j+1] <= $height) {
            continue;
        }

        $riskSum += ($height + 1);
    }
}

var_dump($riskSum);


