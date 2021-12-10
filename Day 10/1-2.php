<?php

$file = fopen('input.txt', 'r');

$lines = [];
while ($line = fgets($file)) {
    $line = str_split(trim($line));
    $lines[] = $line;
}
$corruptedValues = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137
];

$openers = [
    '(' => 1,
    '[' => 2,
    '{' => 3,
    '<' => 4
];

$closers = [
    ')' => 1,
    ']' => 2,
    '}' => 3,
    '>' => 4
];

$corruptedScore = 0;
$incompleteScores = [];
foreach ($lines as $line) {
    $lineOpens = [];
    foreach ($line as $key => $char) {
        if (in_array($char, array_keys($openers))) {
            array_unshift($lineOpens, $char);
        } elseif (in_array($char, array_keys($closers))) {
            $opener = array_shift($lineOpens);
            if ($openers[$opener] !== $closers[$char]) {
                $corruptedScore += $corruptedValues[$char];
                break;
            }
        } else {
            throw new Exception('Invalid Character');
        }

        if ($key === count($line)-1) {
            $score = 0;
            foreach ($lineOpens as $open) {
                $score *= 5;
                $score += $openers[$open];
            }
            $incompleteScores[] = $score;
        }
    }
}

sort($incompleteScores);

echo 'Part 1: ' . $corruptedScore . "\n";
echo 'Part 2: ' . $incompleteScores[(int)floor(count($incompleteScores)/2)];


