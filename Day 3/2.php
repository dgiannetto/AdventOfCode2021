<?php

$input = file('input.txt', FILE_IGNORE_NEW_LINES);
$split = [];

foreach ($input as $row) {
    $split[] = str_split($row);
}

$o2 = $split;
$co2 = $split;
$o2index = 0;
$co2index = 0;

do {
    $filterValue = (getSumByIndex($o2, $o2index) >= (count($o2)/2)) ? 1 : 0;
    $o2 = filterByIndexAndValue($o2, $o2index, $filterValue);
    $o2index++;
} while (count($o2) > 1);

do {
    $filterValue = (getSumByIndex($co2, $co2index) < (count($co2)/2)) ? 1 : 0;
    $co2 = filterByIndexAndValue($co2, $co2index, $filterValue);
    $co2index++;
} while (count($co2) > 1);

echo getDecimalValue(array_shift($o2)) * getDecimalValue(array_shift($co2));

function getSumByIndex(array $array, int $index): int {
    return array_reduce($array, function(?int $sum, array $item) use ($index) {
        if (is_null($sum)) {return $item[$index];}
        return $sum + $item[$index];
    });
}

function filterByIndexAndValue(array $array, int $index, int $value): array {
    return array_filter($array, function ($item) use ($index, $value) {
        return (int)$item[$index] === $value;
    });
}

function getDecimalValue(array $array) : int {
    return bindec(implode($array));
}
