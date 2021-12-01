<?php

$file = file('input.txt');

$count = 0;
$prev = null;

foreach ($file as $key => $depth) {
    if (isset($file[$key+3])) {
        if ((int)$depth < (int)$file[$key+3]) {
            $count++;
        }
    }
}

var_dump($count);
