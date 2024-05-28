<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Card\Player;
use App\Card\Card;

/**
 * Test cases for class Dice.
 */
class PlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreatePlayerDefaultName()
    {
        $player = new Player();

        $res = $player->getName();
        $exp = "Player";

        $this->assertEquals($exp, $res);
    }

    public function testCreatePlayerCustomName()
    {
        $player = new Player("Test");

        $res = $player->getName();
        $exp = "Test";

        $this->assertEquals($exp, $res);
        $this->assertNotEquals("Player", $res);
    }

    public function testAddCard()
    {
        $player = new Player();
        $card = new Card(1, 2);
        $player->addCard($card);

        $res = $player->getCards();

        $this->assertNotEmpty($res);
    }

}