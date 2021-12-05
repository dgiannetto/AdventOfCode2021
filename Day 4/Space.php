<?php

class Space
{
    public $value;
    public $isMarked = false;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
}
