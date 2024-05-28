<?php

namespace App\Card;

class Card
{
    protected int $suit = 0;
    protected int $value = 0;

    public function __construct(int $suit, int $value)
    {
        $this->suit = $suit;
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getSuit(): int
    {
        return $this->suit;
    }

    public function getAsString(): string
    {
        return "[{$this->suit}][{$this->value}]";
    }

}
