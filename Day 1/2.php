<?php

$input = file('input.txt');

$count = 0;
$prev = null;

for ($i = 3; $i < count($input); $i++) {
    $window1 = (int)$input[$i-3] + (int)$input[$i-2] + (int)$input[$i-1];
    $window2 = (int)$input[$i-2] + (int)$input[$i-1] + (int)$input[$i];

    if ($window1 < $window2) {
        $count++;
    }
}

var_dump($count);
