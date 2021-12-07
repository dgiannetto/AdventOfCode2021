<?php

$file = file('input.txt', FILE_IGNORE_NEW_LINES);
$positions = explode(',', $file[0]);

$prev = null;
for ($i = 0; $i <= 1000; $i++) {
    $diff = totalDifference($positions, $i);

    if (!is_null($prev)) {
        if ($diff > $prev) {
            break;
        }
    }

    $prev = $diff;
}

var_dump($i);
var_dump($prev);

function totalDifference(array $array, int $value)
{
    $totalDiff = 0;
    foreach ($array as $item) {
        $diff = abs($item - $value);
        $diff = ($diff * ($diff+1)) / 2;
        $totalDiff += $diff;
    }
    return $totalDiff;
}
