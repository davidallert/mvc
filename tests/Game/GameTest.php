<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Card\Player;

/**
 * Test cases for class Dice.
 */
class GameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateGame()
    {
        $game = new Game();
        $this->assertInstanceOf("\App\Card\Game", $game);
    }
    public function testAddPlayer()
    {
        $game = new Game();
        $player = new Player();
        $game->addPlayer($player);

        $res = $game->getPlayerFromIndex(0);
        $exp = 'App\Card\Player';

        $this->assertInstanceOf($exp, $res);
    }
    public function testGetCurrentPlayer()
    {
        $game = new Game();
        $playerOne = new Player("Test 1");
        $playerTwo = new Player("Test 2");

        $game->addPlayer($playerOne);
        $game->addPlayer($playerTwo);

        $res = $game->getCurrentPlayer()->getName();
        $exp = 'Test 1';

        $this->assertEquals($exp, $res);
    }
    public function testGetPlayerFromIndex()
    {
        $game = new Game();
        $playerOne = new Player("Test 1");
        $playerTwo = new Player("Test 2");

        $game->addPlayer($playerOne);
        $game->addPlayer($playerTwo);

        $res = $game->getPlayerFromIndex(1)->getName();
        $exp = 'Test 2';

        $this->assertEquals($exp, $res);
    }
    public function testStop()
    {
        $game = new Game();
        $playerOne = new Player("Test 1");
        $playerTwo = new Player("Test 2");

        $game->addPlayer($playerOne);
        $game->addPlayer($playerTwo);
        $game->stop();

        $res = $game->getCurrentPlayer()->getName();
        $exp = 'Test 2';

        $this->assertEquals($exp, $res);
    }
}