<?php

$file = fopen('input.txt', 'r');

$vents = [];
while ($line = fgets($file)) {
    preg_match_all('/\d+/', $line, $values);
    $vents[] = $values[0];
}

$map = [];
foreach ($vents as $vent) {
    if ($vent[0] === $vent[2]) {
        addVerticalVent($map, (int)$vent[0], (int)$vent[1], (int)$vent[3]);
    } elseif ($vent[1] === $vent[3]) {
        addHorzontalVent($map, (int)$vent[1], (int)$vent[0], (int)$vent[2]);
    } else {
        addDiagonalVent($map, (int)$vent[0], (int)$vent[1], (int)$vent[2], (int)$vent[3]);
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

function addDiagonalVent(array &$map, int $x1, int $y1, int $x2, int $y2): void
{
    $xDelta = ($x1 > $x2 ? -1 : 1);
    $yDelta = ($y1 > $y2 ? -1 : 1);

    for ($i = 0; $i <= abs($y1 - $y2); $i++) {
        $x = $x1 + ($i * $xDelta);
        $y = $y1 + ($i * $yDelta);

        if (isset($map[$x][$y])) {
            $map[$x][$y]++;
        } else {
            $map[$x][$y] = 1;
        }
    }
}
