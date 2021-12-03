<?php

$input = file('input.txt', FILE_IGNORE_NEW_LINES);
$split = [];

foreach ($input as $row) {
    $split[] = str_split($row);
}

$sums = array_reduce($split, function($sum, $item) {
    if (is_null($sum)) {return $item;}
    foreach ($item as $key => $value) {
        $sum[$key] += (int)$value;
    }
    return $sum;
});

$gamma = array_map(function($sum) use ($input) {
    return ($sum > (count($input)/2) ? 1 : 0);
}, $sums);

$epsilon = array_map(function($sum) use ($input) {
    return ($sum < (count($input)/2) ? 1 : 0);
}, $sums);

echo bindec(implode($gamma)) * bindec(implode($epsilon));
