<?php

namespace App\Card;

class Game
{
    private array $players = []; // Will hold one player object per player.
    private int $currentPlayer = 0; // Keeps track of the current player
    private bool $finished = FALSE;

    // Adds a player to the "players" key-value array.
    public function addPlayer(Player $player) : void
    {
        $this->players[] = $player;
    }

    // Returns the current player.
    public function getCurrentPlayer() : Player
    {
        return $this->players[$this->currentPlayer];
    }

    public function getPlayerFromIndex(int $index) : Player
    {
        // Returns a specific player.
        return $this->players[$index]; // $index 0 is the player and $index 1 is the bank.
    }

    // Calculates the total score for the current player.
    public function calculateScore(int $playerIndex = -1) : int
    {
        $sum = 0;

        // Get the current player and their card hand.
        if ($playerIndex !== -1) {
            $player = $this->getPlayerFromIndex($playerIndex);
        } elseif ($playerIndex === -1) {
            $player = $this->players[$this->currentPlayer];
        };

        $playerCards = $player->getCards();

        // Add each card's value to the total.
        foreach ($playerCards as $card) {
            $sum += $card->getValue();
        }

        return $sum;
    }

    // Changes the current player.
    public function stop() : void
    {
        // Adds +1 to the $currentPlayer : int variable.
        // This will make the game move on to the next player object in the $players : array.
        if ($this->currentPlayer < count($this->players) - 1) {
            $this->currentPlayer += 1;
        }
    }

    // Mark the game as finished.
    public function setFinished() : void
    {
        $this->finished = TRUE;
    }

    // Check if the game is finished.
    public function getFinished() : bool
    {
        return $this->finished;
    }

    public function getVictoryResult() : bool
    {
        $victory = FALSE;
        $playerScore = $this->calculateScore(0);
        $bankScore = $this->calculateScore(1);

        // var_dump($playerScore);
        // var_dump($bankScore);

        if ($playerScore > 21) {
            return $victory;
        } elseif ($bankScore > 21) {
            $victory = true;
            return $victory;
        } elseif ($playerScore === 21 && $bankScore !== 21) {
            $victory = true;
            return $victory;
        } elseif ($bankScore >= $playerScore) {
            return $victory;
        }

        return $victory;
    }
}
