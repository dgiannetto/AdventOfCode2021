<?php

$file = fopen('input.txt', 'r');

$outputs = [];
while ($line = fgets($file)) {
    $line = substr($line, strpos($line, '|')+2);
    $outputs = array_merge($outputs, explode( ' ', trim($line)));
}

$answer = array_reduce($outputs, function ($carry, $item) {
    if (is_null($carry)) {$carry = 0;}

    if (in_array(strlen($item), [2,3,4,7])) {
        $carry++;
    }

    return $carry;
});

var_dump($answer);
