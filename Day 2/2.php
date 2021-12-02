<?php

$file = fopen('input.txt', 'r');
$position = [
    'forward' => 0,
    'depth' => 0,
    'aim' => 0
];

while ($data = fgetcsv($file, 12, ' ')) {
    switch (strtolower($data[0])) {
        case 'forward':
            $position['forward'] += (int)$data[1];
            $position['depth'] += $position['aim'] * (int)$data[1];
            continue;
        case 'down':
            $position['aim'] += (int)$data[1];
            continue;
        case 'up':
            $position['aim'] -= (int)$data[1];
            continue;
        default:
            continue;
    }
}

echo $position['forward'] * $position['depth'];
