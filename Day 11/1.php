<?php

$file = fopen('input.txt', 'r');

$octopuses = [];
while ($line = fgets($file)) {
    $line = str_split(trim($line));
    $octopuses[] = $line;
}

$count = 0;
for ($i = 0; $i < 100; $i++) {
    incrementAll($octopuses);
    processFlashes($octopuses);
    $count += resetFlashed($octopuses);
}

echo 'Total flashes: ' . $count;

function outputOctopuses (array $array): void
{
    foreach ($array as $row) {
        echo implode(' ', $row) . "\n";
    }
    echo "\n";
}

function resetFlashed(array &$array): int
{
    $count = 0;
    foreach ($array as $i => $column) {
        foreach ($column as $j => $value) {
            if ($array[$i][$j] > 9) {
                $array[$i][$j] = 0;
                $count++;
            }
        }
    }
    return $count;
}

function processFlashes(array &$array): void
{
    $flashed = [];
    foreach ($array as $i => $column) {
        foreach ($column as $j => $value) {
            if ($array[$i][$j] > 9) {
                $flashed[$i][$j] = 1;
            }
        }
    }

    foreach ($flashed as $i => $column) {
        foreach ($column as $j => $value) {
            recursivelyIncrementAdjacent($array, $i, $j, $flashed);

        }
    }
}

function incrementAll(array &$array): void
{
    foreach ($array as $i => $column) {
        foreach ($column as $j => $value) {
            $array[$i][$j]++;
        }
    }
}

function recursivelyIncrementAdjacent(array &$array, int $i, int $j, array &$flashed): void
{
    for ($a = ($i-1); $a < ($i+2); $a++) {
        for ($b = ($j-1); $b < ($j+2); $b++) {
            if (isset($array[$a][$b])) {
                $array[$a][$b]++;

                if ($array[$a][$b] > 9 && !isset($flashed[$a][$b])) {
                    $flashed[$a][$b] = 1;
                    recursivelyIncrementAdjacent($array, $a, $b, $flashed);
                }
            }
        }
    }
}
