<?php

$file = fopen('input.txt', 'r');

$inputs = [];
$outputs = [];
$maps = [];
while ($line = fgets($file)) {
    $split = strpos($line, '|');
    $inputLine = substr($line, 0, $split-1);
    $outputLine = substr($line, $split+2);
    array_push($inputs, explode( ' ', trim($inputLine)) + ['line' => $inputLine]);
    array_push($outputs, explode( ' ', trim($outputLine)));
}

foreach ($inputs as $input) {
    $maps[] = findDigitMap($input);
}

$sum = 0;
foreach ($outputs as $key => $output) {
    $map = $maps[$key];
    $value = '';

    foreach ($output as $item) {
        foreach ($map as $key2 => $number) {
            $a = str_split($item);
            $b = str_split($number);
            sort($a);
            sort($b);

            if ($a === $b) {
                $x = $key2;
                break;
            }
        }

        $value .= (string)$x;
    }

    $sum += (int)$value;
}

var_dump($sum);

function findDigitMap(array $input): array
{
    $line = $input['line'];
    unset($input['line']);

    $chars = [
        'a',
        'b',
        'c',
        'd',
        'e',
        'f',
        'g',
    ];

    $charMap = [
        'a' => null,
        'b' => null,
        'c' => null,
        'd' => null,
        'e' => null,
        'f' => null,
        'g' => null,
    ];

    $lengths = [
        2 => null,
        3 => null,
        4 => null,
        5 => [],
        6 => [],
        7 => null
    ];

    foreach ($input as $item) {
        if (is_null($lengths[strlen($item)])) {
            $lengths[strlen($item)] = $item;
        } else {
            array_push($lengths[strlen($item)], $item);
        }
    }

    foreach ($chars as $key => $char) {
        $count = substr_count($line,$char);
        switch ($count) {
            case 4:
                $charMap['e'] = $char;
                break;
            case 6:
                $charMap['b'] = $char;
                break;
            case 7:
                if (strpos($lengths[4], $char) !== false) {
                    $charMap['d'] = $char;
                } else {
                    $charMap['g'] = $char;
                }
                break;
            case 8:
                if (strpos($lengths[4], $char) !== false) {
                    $charMap['c'] = $char;
                } else {
                    $charMap['a'] = $char;
                }
                break;
            case 9:
                $charMap['f'] = $char;
                break;
            default:
                break;
        }
    }

    $map[1] = $lengths[2];
    $map[4] = $lengths[4];
    $map[7] = $lengths[3];
    $map[8] = $lengths[7];

    foreach ($lengths[5] as $item) {
        if (strpos($item, $charMap['b']) === false && strpos($item, $charMap['f']) === false) {
            $map[2] = $item;
        } elseif (strpos($item, $charMap['b']) === false && strpos($item, $charMap['e']) === false) {
            $map[3] = $item;
        } elseif (strpos($item, $charMap['c']) === false && strpos($item, $charMap['e']) === false) {
            $map[5] = $item;
        }
    }

    foreach ($lengths[6] as $item) {
        if (strpos($item, $charMap['d']) === false) {
            $map[0] = $item;
        } elseif (strpos($item, $charMap['e']) === false) {
            $map[9] = $item;
        } elseif (strpos($item, $charMap['c']) === false) {
            $map[6] = $item;
        }
    }

    return $map;
}
