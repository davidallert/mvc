<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardGraphic;

class Deck
{
    // /** @var CardGraphic[] */
    private array $drawnCardsDeck = [];
    private array $drawnCardsDeckBank = [];
    private const CARDS_IN_SUIT = 13;
    private const SUITS = 4;
    private array $deck = [];
    private CardGraphic $lastDrawnCard;

    public function __construct(array $deck = [])
    {
        $this->deck = $deck;
    }

    public function addCard(Card $card): void
    {
        $this->deck[] = $card;
    }

    public function createDeck(): void
    {
        for ($suitNum = 1; $suitNum <= self::SUITS; $suitNum++) {
            for ($cardNum = 1; $cardNum <= self::CARDS_IN_SUIT; $cardNum++) {
                $card = new CardGraphic($suitNum, $cardNum);
                $this->addCard($card);
            }
        }
    }

    public function createDeckJson(): void
    {
        for ($suitNum = 1; $suitNum <= self::SUITS; $suitNum++) {
            for ($cardNum = 1; $cardNum <= self::CARDS_IN_SUIT; $cardNum++) {
                $card = new Card($suitNum, $cardNum);
                $this->addCard($card);
            }
        }
    }

    // public function getCards(): array
    // {
    //     $deck = [];
    //     foreach ($this->deck as $card) {
    //         $deck[$card->getSuit()][] = $card->getValue();
    //     }
    //     return $deck;
    //     // var_dump($deck);
    // }

    public function countCards(): int
    {
        return count($this->deck);
    }

    public function getCardsAsString(): array
    {
        $deckGraphic = [];
        foreach ($this->deck as $card) {
            $deckGraphic[] = $card->getAsString();
        }
        return $deckGraphic;
        // var_dump($deck);
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function draw(int $numOfCards = 1, int $returnDeckIndex = 1): array
    {
        $cardsInDeck = count($this->deck);
        $default = true; // $drawnCardsDeck is always used by default.

        if ($cardsInDeck === 0) {
            return $this->drawnCardsDeck;
        }

        for ($i = 0; $i < $numOfCards; $i++) {
            $drawCard = random_int(0, $cardsInDeck - 1);
            $this->lastDrawnCard = $this->deck[$drawCard];

            // Add the drawn card objects to the secondary deck.
            if ($returnDeckIndex === 1) { // Default deck.
                $this->drawnCardsDeck[] = $this->deck[$drawCard];
            } elseif ($returnDeckIndex === 2) {
                $this->drawnCardsDeckBank[] = $this->deck[$drawCard];
                $default = false;
            }

            // Remove the drawn card from the main deck.
            unset($this->deck[$drawCard]);
            // Fix the main deck key/value array.
            $this->deck = array_values($this->deck);
            $cardsInDeck = count($this->deck);
        }

        if ($default) {
            return $this->drawnCardsDeck;
        }

        return $this->drawnCardsDeckBank;
        // return $this->deck;
        // var_dump($cards_in_deck);
        // var_dump($this->deck);
    }

    public function getLastDrawnCard() : cardGraphic
    {
        return $this->lastDrawnCard;
    }

    public function getDrawnCards() : array
    {
        return $this->drawnCardsDeck;
    }
}
