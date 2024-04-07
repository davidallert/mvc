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
        } else {
            $deck = $session->get("deck");
        }

        $drawn_cards_arr = $deck->draw();
        $drawn_cards_deck = new Deck();
        foreach ($drawn_cards_arr as $card) {
            $drawn_cards_deck->addCard($card);
        }

        $drawn_cards_deck = $drawn_cards_deck->getCardsAsString();

        $session->set("deck", $deck);

        $data = [
            'cards_left' => $deck->countCards(),
            'drawn_cards_deck' => $drawn_cards_deck,
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
        } else {
            $deck = $session->get("deck");
        }

        $drawn_cards_arr = $deck->draw($num);
        $drawn_cards_deck = new Deck();
        foreach ($drawn_cards_arr as $card) {
            $drawn_cards_deck->addCard($card);
        }

        $drawn_cards_deck = $drawn_cards_deck->getCardsAsString();

        $session->set("deck", $deck);

        $data = [
            'cards_left' => $deck->countCards(),
            'drawn_cards_deck' => $drawn_cards_deck,
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
}
