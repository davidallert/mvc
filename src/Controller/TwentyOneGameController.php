<?php

namespace App\Controller;

use App\Card\Deck;
use App\Card\Player;
use App\Card\Game;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

// Request and session interfaces.
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TwentyOneGameController extends AbstractController
{
    // Game overview ..............................................................................
    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render("game/game.html.twig");
    }

    // Documentation ..............................................................................
    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response
    {
        return $this->render("game/doc.html.twig");
    }

    // Initialize the game ........................................................................
    #[Route("/game/init", name: "game_init")]
    public function init(
        sessionInterface $session
    ): Response {
        // Start FRESH.
        $session->clear();

        // Create the deck of cards.
        $deck = new Deck();
        $deck->createDeck();

        // Create the players.
        $player = new Player(); // Default name is "Player"
        $bank = new Player("Bank");

        // Start the game
        $game = new Game();
        $game->addPlayer($player);
        $game->addPlayer($bank);

        // Save data to the session.
        $session->set("deck", $deck);
        $session->set("game", $game);
        $session->set("bank_cards", []);
        $session->set("bank_score", 0);
        $session->set("player_name", $player->getName());

        return $this->redirectToRoute('game_board');
    }

    // Game board .................................................................................
    #[Route("/game/play", name: "game_board")]
    public function play(
        sessionInterface $session,
        UrlGeneratorInterface $urlGenerator
    ): Response {

        // Init vars.
        $playerCards = [];
        $playerScore = 0;

        // Get from session.
        $game = $session->get("game");

        // Get the current player.
        $player = $game->getCurrentPlayer();
        // $player_name = $player->getName();

        // Get the drawn card objects as an array.
        if ($player->getCards() && $player->getName() != "Bank") {
            $playerCards = $player->getCards();
            $playerScore = $game->calculateScore();
            $session->set("cards_in_hand", $playerCards);
            $session->set("player_score", $playerScore);

            if ($playerScore > 21) {
                $game->setFinished();
            }
        };

        if ($game->getFinished()) {
            $winner = $game->getVictoryResult();
            // $newPageUrl = "http://localhost:8888/game/init";
            $newPageUrl = $urlGenerator->generate("game_init");
            if ($winner) {
                $this->addFlash(
                    'notice',
                    sprintf('Congrats, you won! <a href="%s">Play again</a>', $newPageUrl)
                );
            } elseif (!$winner) {
                $this->addFlash(
                    'notice',
                    sprintf('You lost, noob! <a href="%s">Play again</a>', $newPageUrl)
                );
            }
        }

        // Save to $data.
        $data = [
            // 'session' => $session->all(),
            'cards_in_hand' => $session->get("cards_in_hand"),
            'player_score' => $session->get("player_score"),
            'player_name' => $session->get("player_name"),
            'bank_cards' => $session->get("bank_cards"),
            'bank_score' => $session->get("bank_score"),
        ];

        return $this->render("game/game_board.html.twig", $data);
    }

    // Draw .......................................................................................
    #[Route("/game/draw", name: "game_draw")]
    public function draw(
        sessionInterface $session
    ): Response {
        // Get from session.
        $game = $session->get("game");
        $deck = $session->get("deck");

        // Draw a card.
        $deck->draw();
        $lastDrawnCard = $deck->getLastDrawnCard();

        // Get the current player and add the drawn card to their hand.
        $player = $game->getCurrentPlayer();
        $player->addCard($lastDrawnCard);

        return $this->redirectToRoute('game_board');
    }

    // Stop .......................................................................................
    #[Route("/game/stop", name: "game_stop")]
    public function stop(
        sessionInterface $session
    ): Response {

        $bank = null;

        // Get from session.
        $game = $session->get("game");
        $deck = $session->get("deck");

        $game->stop();

        // The bank draws its cards while it has less than or equal to 17 points.
        while ($game->calculateScore() <= 17) {
            $deck->draw();
            $lastDrawnCard = $deck->getLastDrawnCard();
            $bank = $game->getCurrentPlayer();
            $bank->addCard($lastDrawnCard);
        }

        $game->setFinished();

        // Save the bank score to the session.
        $session->set("bank_score", $game->calculateScore());
        if ($bank) {
            $session->set("bank_cards", $bank->getCards());
        }

        return $this->redirectToRoute('game_board');
    }
}
