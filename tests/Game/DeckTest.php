<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Card\Player;
use App\Card\Card;
use App\Card\Deck;

/**
 * Test cases for class Dice.
 */
class DeckTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDeck()
    {
        $deck = new Deck();
        $deck->createDeck();

        $res = $deck->countCards();
        $exp = 52;

        $this->assertEquals($exp, $res);
    }

    public function testGetCardsAsString()
    {
        $deck = new Deck();
        $deck->createDeck();

        $res = $deck->getCardsAsString();

        $this->assertNotEmpty($res);
    }

    public function testDrawOne()
    {
        $deck = new Deck();
        $deck->createDeck();
        $deck->draw();

        $res = $deck->getLastDrawnCard();

        $this->assertNotEmpty($res);
    }

    public function testDrawMany()
    {
        $deck = new Deck();
        $deck->createDeck();
        $deck->draw(10);

        $res = $deck->countCards();
        $exp = 42;

        $this->assertNotEmpty($exp, $res);
    }

    public function testGetDrawnCards()
    {
        $deck = new Deck();
        $deck->createDeck();
        $deck->draw(10);
        $drawnCards = $deck->getDrawnCards();

        $res = count($drawnCards);
        $exp = 10;

        $this->assertNotEmpty($exp, $res);
    }

    public function testShuffle()
    {
        $deck = new Deck();
        $deck->createDeck();
        $deck->shuffle();

        $res = $deck->countCards();
        $exp = 52;

        $this->assertEquals($exp, $res);
    }

}