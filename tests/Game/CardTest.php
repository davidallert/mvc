<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Card\Card;

/**
 * Test cases for class Dice.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testGetValue()
    {
        $card = new Card(1, 2);

        $res = $card->getValue();
        $exp = 2;

        $this->assertEquals($exp, $res);
    }

    public function testGetSuit()
    {
        $card = new Card(1, 2);

        $res = $card->getSuit();
        $exp = 1;

        $this->assertEquals($exp, $res);
    }

    public function testGetAsString()
    {
        $card = new Card(1, 2);

        $res = $card->getAsString();
        $exp = '[1][2]';

        $this->assertEquals($exp, $res);
    }
}