<?php

include "Card.php";
include "Space.php";

$file = fopen('input.txt', 'r');

$numbers = fgetcsv($file, 0, ',');

$cards = [];
$newCard = true;

while ($line = fgetcsv($file, 0, ' ')) {
    if ($line === [null]) {
        $newCard = true;
        continue;
    }

    if ($newCard) {
        $cards[] = new Card();
        $newCard = false;
    }

    $spaces = [];
    foreach ($line as $item) {
        if ($item !== "") {
            $spaces[] = new Space((int)$item);
        }
    }

    /** @var Card $card */
    $card = end($cards);
    $card->addSpaces($spaces);
}

$winningCard = null;
$winningNumber = null;

foreach ($numbers as $number) {
    /** @var Card $card */
    foreach ($cards as $card) {
        $card->markSpaces((int)$number);
        if ($card->isWinning) {
            $winningCard = $card;
        }
    }

    if (!is_null($winningCard)) {
        $winningNumber = $number;
        break;
    }
}

echo 'Part 1: ' . $winningCard->getUnmarkedSum() * $winningNumber;
