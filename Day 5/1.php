<?php

$file = fopen('input.txt', 'r');

$vents = [];
while ($line = fgets($file)) {
    preg_match_all('/\d+/', $line, $values);

    $values = $values[0];

    if ($values[0] === $values[2] || $values[1] === $values[3]) {
        $vents[] = $values;
    }
}

$map = [];
foreach ($vents as $vent) {
    if ($vent[0] === $vent[2]) {
        addVerticalVent($map, (int)$vent[0], (int)$vent[1], (int)$vent[3]);
    } else {
        addHorzontalVent($map, (int)$vent[1], (int)$vent[0], (int)$vent[2]);
    }
}

$output = [];
foreach ($map as $row) {
    $output[] = array_reduce($row, function ($carry, $item) {
        if (is_null($carry)) {
            $carry = 0;
        }

        if ($item > 1) {
            $carry++;
        }

        return $carry;
    });
}

echo array_sum($output);

function addVerticalVent(array &$map, int $x, int $y1, int $y2): void
{
    if ($y1 > $y2) {
        $tmp = $y1;
        $y1 = $y2;
        $y2 = $tmp;
    }

    for ($i = $y1; $i <= $y2; $i++) {
        if (isset($map[$x][$i])) {
            $map[$x][$i]++;
        } else {
            $map[$x][$i] = 1;
        }
    }
}

function addHorzontalVent(array &$map, int $y, int $x1, int $x2): void
{
    if ($x1 > $x2) {
        $tmp = $x1;
        $x1 = $x2;
        $x2 = $tmp;
    }

    for ($i = $x1; $i <= $x2; $i++) {
        if (isset($map[$i][$y])) {
            $map[$i][$y]++;
        } else {
            $map[$i][$y] = 1;
        }
    }
}
