<?php

namespace App\Controller;

use App\Card\Deck;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Request and session interfaces.
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class JsonApi
{
    #[Route("/api/deck")]
    public function jsonDeck(): Response
    {
        $deck = new Deck();
        $deck->createDeckJson();

        $data = [
            'deck' => $deck->getCardsAsString(),
        ];

        return new JsonResponse($data);
    }

    #[Route("/api/deck/shuffle")]
    public function jsonDeckShuffle(): Response
    {
        $deck = new Deck();
        $deck->createDeckJson();
        $deck->shuffle();

        $data = [
            'deck' => $deck->getCardsAsString(),
        ];

        return new JsonResponse($data);
    }

    #[Route("/api/deck/draw")]
    public function jsonDeckDraw(
        sessionInterface $session
    ): Response {
        if (!$session->get("deck")) {
            $deck = new Deck();
            $deck->createDeckJson();
        } elseif ($session->get("deck")) {
            $deck = $session->get("deck");
        }

        $drawnCardsArr = $deck->draw();
        $drawnCardsDeck = new Deck();
        foreach ($drawnCardsArr as $card) {
            $drawnCardsDeck->addCard($card);
        }

        $drawnCardsDeck = $drawnCardsDeck->getCardsAsString();

        $session->set("deck", $deck);

        $data = [
            'cards_left' => $deck->countCards(),
            'drawn_cards_deck' => $drawnCardsDeck,
        ];

        return new JsonResponse($data);
    }

    #[Route("/api/deck/draw/{num<\d+>}")]
    public function jsonDeckDrawMany(
        int $num,
        sessionInterface $session
    ): Response {
        if (!$session->get("deck")) {
            $deck = new Deck();
            $deck->createDeckJson();
        } elseif ($session->get("deck")) {
            $deck = $session->get("deck");
        }

        $drawnCardsArr = $deck->draw($num);
        $drawnCardsDeck = new Deck();
        foreach ($drawnCardsArr as $card) {
            $drawnCardsDeck->addCard($card);
        }

        $drawnCardsDeck = $drawnCardsDeck->getCardsAsString();

        $session->set("deck", $deck);

        $data = [
            'cards_left' => $deck->countCards(),
            'drawn_cards_deck' => $drawnCardsDeck,
        ];

        return new JsonResponse($data);
    }

    #[Route("api/session/delete")]
    public function clearSession(
        sessionInterface $session
    ): Response {
        $session->clear();
        return new JsonResponse(null);
    }

    #[Route("api/game")]
    public function game(
        sessionInterface $session
    ): Response {
        $data = [
            // 'cards_in_hand' => $session->get("cards_in_hand"),
            'player_score'  => $session->get("player_score"),
            'player_name'   => $session->get("player_name"),
            // 'bank_cards'    => $session->get("bank_cards"),
            'bank_score'    => $session->get("bank_score"),
        ];
        return new JsonResponse($data);
    }
}
