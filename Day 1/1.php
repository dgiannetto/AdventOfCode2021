<?php

$file = file('input.txt');

$count = 0;
$prev = null;

foreach ($file as $depth) {
    if (!is_null($prev) && (int)$prev < (int)$depth) {
        $count++;
    }

    $prev = $depth;
}

var_dump($count);
