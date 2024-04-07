<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardGraphic;

class Deck
{
    private $drawn_cards_deck = [];
    private const CARDS_IN_SUIT = 13;
    private const SUITS = 4;

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
        for ($suit_num = 1; $suit_num <= self::SUITS; $suit_num++) {
            for ($card_num = 1; $card_num <= self::CARDS_IN_SUIT; $card_num++) {
                $card = new CardGraphic($suit_num, $card_num);
                $this->addCard($card);
            }
        }
    }

    public function createDeckJson(): void
    {
        for ($suit_num = 1; $suit_num <= self::SUITS; $suit_num++) {
            for ($card_num = 1; $card_num <= self::CARDS_IN_SUIT; $card_num++) {
                $card = new Card($suit_num, $card_num);
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

    public function draw($num_of_cards = 1): array
    {
        $cards_in_deck = count($this->deck);

        if ($cards_in_deck === 0) {
            return $this->drawn_cards_deck;
        }

        for ($i = 0; $i < $num_of_cards; $i++) {
            $draw_card = random_int(0, $cards_in_deck - 1);

            // Add the drawn card objects to the secondary deck.
            $this->drawn_cards_deck[] = $this->deck[$draw_card];

            // Remove the drawn card from the main deck.
            unset($this->deck[$draw_card]);
            // Fix the main deck key/value array.
            $this->deck = array_values($this->deck);
            $cards_in_deck = count($this->deck);
        }

        return $this->drawn_cards_deck;
        // return $this->deck;
        // var_dump($cards_in_deck);
        // var_dump($this->deck);
    }

}
