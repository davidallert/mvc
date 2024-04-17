<?php

namespace App\Card;

// The player class holds information about the player.
class Player
{
    // Initiate the player class with a name. (Constructor.)

    // Private variable $cards : array contains the cards in the player's hand.
    private array $cardsInHand = [];
    private string $name;

    // Private variable $name : str contains the player name.
    public function __construct(string $name = "Player")
    {
        $this->name = $name;
    }

    // Adds a card to the player's hand.
    public function addCard(Card $card) : void
    {
        $this->cardsInHand[] = $card;
    }

    // Returns the cards in the player's hand.
    public function getCards(): array
    {
        return $this->cardsInHand;
    }

    // Returns the player name.
    public function getName(): string
    {
        return $this->name;
    }
}
