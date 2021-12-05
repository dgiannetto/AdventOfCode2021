<?php

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
    foreach ($cards as $index => $card) {
        $card->markSpaces((int)$number);
        if ($card->isWinning) {
            unset($cards[$index]);
            $winningCard = $card;
        }
    }

    if (count($cards) === 0) {
        $winningNumber = $number;
        break;
    }
}


echo 'Part 2: ' . $winningCard->getUnmarkedSum() * $winningNumber;


class Card
{
    public $spaces;
    public $isWinning;

    public function __construct() {}

    /**
     * @param Space[] $spaces
     */
    public function addSpaces(array$spaces): void
    {
        $this->spaces[] = $spaces;
    }

    public function markSpaces(int $num): void
    {
        $spaceMarked = false;
        foreach ($this->spaces as $rows) {
            /** @var Space $space */
            foreach ($rows as $space) {
                if ($space->value === $num) {
                    $space->isMarked = true;
                    $spaceMarked = true;
                }
            }
        }

        if ($spaceMarked && !$this->isWinning) {
            $this->isWinning = $this->checkForWin();
        }
    }

    private function checkForWin(): bool
    {
        $win = $this->checkRows();

        if (!$win)  {
            $win = $this->checkColumns();
        }

        return $win;
    }

    private function checkRows(): bool
    {
        foreach ($this->spaces as $row) {
            if ($this->checkArrayForWin($row)) {
                return true;
            }
        }
        return false;
    }

    private function checkColumns(): bool
    {
        for ($i = 0; $i < 5; $i++) {
            if ($this->checkArrayForWin(array_column($this->spaces, $i))) {
                return true;
            }
        }
        return false;
    }

    private function checkArrayForWin(array $array): bool
    {
        /** @var Space $space */
        foreach ($array as $space) {
            if ($space->isMarked === false) {
                return false;
            }
        }
        return true;
    }

    public function getUnmarkedSum(): int
    {
        $sum = 0;
        foreach ($this->spaces as $rows) {
            /** @var Space $space */
            foreach ($rows as $space) {
                if (!$space->isMarked) {
                    $sum += $space->value;
                }
            }
        }
        return $sum;
    }
}

class Space
{
     public $value;
     public $isMarked = false;

     public function __construct(int $value)
     {
         $this->value = $value;
     }
}
