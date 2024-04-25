<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Card\Player;
use App\Card\Card;

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
    public function testFinished()
    {
        $game = new Game();

        $game->setFinished();

        $res = $game->getFinished();
        $exp = TRUE;

        $this->assertEquals($exp, $res);
    }
    public function testCalculateScore()
    {
        $game = new Game();
        $player = new Player();

        $cardKing = new Card(1, 13);
        $cardQueen = new Card(2, 12);
        $cardKnight = new Card(3, 11);
        $cardAce = new Card(4, 1);

        $player->addCard($cardKing);
        $player->addCard($cardQueen);
        $player->addCard($cardKnight);
        $player->addCard($cardAce);

        $game->addPlayer($player);

        $res = $game->calculateScore();
        $exp = 37;

        $this->assertEquals($exp, $res);
    }
    public function testGetVictoryResultWin()
    {
        $game = new Game();
        $player = new Player("Player");
        $bank = new Player("Bank");
        $cardKing = new Card(1, 13);
        $cardKnight = new Card(2, 11);
        $cardSix = new Card(2, 6);
        $cardSeven = new Card(2, 7);

        $player->addCard($cardKing);
        $player->addCard($cardSix);

        $bank->addCard($cardKnight);
        $bank->addCard($cardSeven);

        $game->addPlayer($player);
        $game->addPlayer($bank);

        $res = $game->getVictoryResult();
        $exp = TRUE;

        $this->assertEquals($exp, $res);
    }
    public function testGetVictoryResultLoss()
    {
        $game = new Game();
        $player = new Player("Player");
        $bank = new Player("Bank");
        $cardKing = new Card(1, 13);
        $cardKnight = new Card(2, 11);
        $cardSix = new Card(2, 6);
        $cardSeven = new Card(2, 7);

        $player->addCard($cardKnight);
        $player->addCard($cardSeven);

        $bank->addCard($cardKing);
        $bank->addCard($cardSix);

        $game->addPlayer($player);
        $game->addPlayer($bank);

        $res = $game->getVictoryResult();
        $exp = FALSE;

        $this->assertEquals($exp, $res);
    }
    public function testGetVictoryResultPlayerExceedingTwentyOne()
    {
        $game = new Game();
        $player = new Player("Player");
        $bank = new Player("Bank");
        $cardKing = new Card(1, 13);
        $cardQueen = new Card(2, 12);

        $player->addCard($cardKing);
        $player->addCard($cardQueen);

        $game->addPlayer($player);
        $game->addPlayer($bank);

        $res = $game->getVictoryResult();
        $exp = FALSE;

        $this->assertEquals($exp, $res);
    }
    public function testGetVictoryResultBankExceedingTwentyOne()
    {
        $game = new Game();
        $player = new Player("Player");
        $bank = new Player("Bank");
        $cardKing = new Card(1, 13);
        $cardQueen = new Card(2, 12);

        $bank->addCard($cardKing);
        $bank->addCard($cardQueen);

        $game->addPlayer($player);
        $game->addPlayer($bank);

        $res = $game->getVictoryResult();
        $exp = TRUE;

        $this->assertEquals($exp, $res);
    }
    public function testGetVictoryResultTwentyOne()
    {
        $game = new Game();
        $player = new Player("Player");
        $bank = new Player("Bank");
        $cardKing = new Card(1, 13);
        $cardEight = new Card(2, 8);

        $player->addCard($cardKing);
        $player->addCard($cardEight);

        $game->addPlayer($player);
        $game->addPlayer($bank);

        $res = $game->getVictoryResult();
        $exp = TRUE;

        $this->assertEquals($exp, $res);
    }
}