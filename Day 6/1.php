<?php

$file = file('input.txt', FILE_IGNORE_NEW_LINES);

$fish = explode(',', $file[0]);

$counts = array_reduce($fish, function ($counts, $item) {
    if (is_null($counts)) {
        $counts = [
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
        ];
    }

    $counts[(int)$item]++;
    return $counts;
});

for ($i = 0; $i < 80; $i++) {
    processCounts($counts);
}

echo array_sum($counts);


function processCounts(array &$counts): void
{
    $zeroes = null;
    foreach ($counts as $count => $value) {
        if ($count === 0) {
            $zeroes = $value;
        } else {
            $counts[$count-1] = $value;
        }
    }
    $counts[6] += $zeroes;
    $counts[8] = $zeroes;
}
