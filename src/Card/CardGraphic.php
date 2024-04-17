<?php

namespace App\Card;

class CardGraphic extends Card
{

    private array $representation = [
        1 => ["🃑", "🃒", "🃓", "🃔", "🃕", "🃖", "🃗", "🃘", "🃙", "🃚", "🃛", "🃝", "🃞"], # Ace - King of Clubs
        2 => ["🃁", "🃂", "🃃", "🃄", "🃅", "🃆", "🃇", "🃈", "🃉", "🃊", "🃋", "🃍", "🃎"], # Ace - King of Diamonds
        3 => ["🂱", "🂲", "🂳", "🂴", "🂵", "🂶", "🂷", "🂸", "🂹", "🂺", "🂻", "🂽", "🂾"], # Ace - King of Hearts
        4 => ["🂡", "🂢", "🂣", "🂤", "🂥", "🂦", "🂧", "🂨", "🂩", "🂪", "🂫", "🂭", "🂮"] # Ace - King of Spades
    ];

    public function __construct(int $suit, int $value)
    {
        parent::__construct($suit, $value);
    }

    public function getAsString(): string
    {
        return $this->representation[$this->suit][$this->value - 1];
    }
}
