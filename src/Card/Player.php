<?php

namespace App\Card;

/**
 * The player class holds information about the player.
 */

class Player
{

    /**
     * Private variable $cardsInHand : array contains the cards in the player's hand.
     * @var Card[]
     */
    private array $cardsInHand = [];

    /**
     * @var string
     */
    private string $name;

    /** 
     * Initiate the player class with a name.
     * 
     * @param string $name Contains the player's name.
     */
    public function __construct(string $name = "Player")
    {
        $this->name = $name;
    }

    /**
     * Adds a card to the player's hand.
     * 
     * @param Card $card The card parameter.
     */
    public function addCard(Card $card) : void
    {
        $this->cardsInHand[] = $card;
    }

    /**
     * Returns the cards in the player's hand.
     * 
     * @return array The player's cards.
     */ 
    public function getCards(): array
    {
        return $this->cardsInHand;
    }

    /**
     * Returns the player name.
     * 
     * @return string The player's name.
     */
    public function getName(): string
    {
        return $this->name;
    }
}
