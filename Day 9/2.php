<?php

$file = fopen('input.txt', 'r');

$heightMap = [];
while ($line = fgets($file)) {
    $line = str_split(trim($line));
    $heightMap[] = $line;
}

$basinSizes = [];
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

        $currentBasin = [];
        $basinSizes[] = getBasinSize($heightMap, $i, $j, $currentBasin);
    }
}

rsort($basinSizes);
var_dump($basinSizes[0] * $basinSizes[1] * $basinSizes[2]);

function getBasinSize(array $heightMap, int $i, int $j, array &$basin): int
{
    $basin[$i][$j] = 1;
    if ($heightMap[$i][$j] == 9) {
        return 0;
    } else {
        $size = 1;
        if (isset($heightMap[$i-1][$j]) && !isset($basin[$i-1][$j])) {
            $size += getBasinSize($heightMap, $i-1, $j, $basin);
        }
        if (isset($heightMap[$i+1][$j]) && !isset($basin[$i+1][$j])) {
            $size += getBasinSize($heightMap, $i+1, $j, $basin);
        }
        if (isset($heightMap[$i][$j-1]) && !isset($basin[$i][$j-1])) {
            $size += getBasinSize($heightMap, $i, $j-1, $basin);
        }
        if (isset($heightMap[$i][$j+1]) && !isset($basin[$i][$j+1])) {
            $size += getBasinSize($heightMap, $i, $j+1, $basin);
        }
        return $size;
    }
}
