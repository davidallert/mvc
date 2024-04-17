<?php

namespace App\Controller;

// Classes
use App\Card\Deck;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Request and session interfaces.
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    // Card overview ..............................................................................
    #[Route("/card", name: "card")]
    public function card(
        sessionInterface $session
    ): Response {
        if (!$session->get('deck_obj')) {
            $deck = new Deck();
            $deck->createDeck();
            $session->set("deck_obj", $deck);
        };
        // var_dump($session);
        return $this->render("card/card.html.twig");
    }

    // Deck .......................................................................................
    #[Route("/card/deck", name: "deck")]
    public function deck(
        sessionInterface $session
    ): Response {
        $deck = $session->get("deck_obj");

        // $deck = new Deck($deck);
        $deckRepresentation = $deck->getCardsAsString();

        $data = [
            "deckRepresentation" => $deckRepresentation
        ];
        // var_dump($deck);
        // var_dump($session);
        return $this->render("card/deck.html.twig", $data);
    }

    // Shuffle ....................................................................................
    #[Route("/card/deck/shuffle", name: "deck_shuffle")]
    public function shuffleDeck(
        sessionInterface $session
    ): Response {
        // $deck = $session->get("deck_obj");

        $deck = new Deck();
        $deck->createDeck();
        $session->set("deck_obj", $deck);
        $shuffleDeck = clone  $deck;
        $shuffleDeck->shuffle();
        $deckRepresentation = $shuffleDeck->getCardsAsString();

        $data = [
            "deckRepresentation" => $deckRepresentation
        ];
        // var_dump($deck);
        return $this->render("card/deck.html.twig", $data);
    }

    // Draw .......................................................................................
    #[Route("/card/deck/draw", name: "deck_draw")]
    public function drawFromDeck(
        sessionInterface $session
    ): Response {
        $deck = $session->get("deck_obj");

        // Drawn cards.
        $drawnCardsArr = $deck->draw();
        $drawnCardsDeck = new Deck();
        foreach ($drawnCardsArr as $card) {
            $drawnCardsDeck->addCard($card);
        }

        $drawnCardsDeck = $drawnCardsDeck->getCardsAsString();

        $session->set("drawn_cards_deck", $drawnCardsDeck);
        $session->set("deck_obj", $deck);

        return $this->redirectToRoute('deck_drawn');
    }

    // Display drawn cards ....................................................................
    #[Route("/card/deck/drawn", name: "deck_drawn")]
    public function displayDrawnDeck(
        sessionInterface $session
    ): Response {
        $data = [
            "drawn_cards_deck" => $session->get("drawn_cards_deck"),
            "cards_left" => $session->get("deck_obj")->countCards()
        ];

        return $this->render("card/deck_draw.html.twig", $data);
    }

    // Draw many ..................................................................................
    // #[Route("/card/deck/draw/{num<\d+>}", name: "deck_draw_many")]
    // public function DrawManyFromDeck(
    //     sessionInterface $session
    // ): Response
    // {
    //     $deck = $session->get("deck_obj");
    //     $deck->draw(5);
    //     $session->set("deck_obj", $deck);

    //     return $this->redirectToRoute('deck');
    // }

    #[Route("/card/deck/draw/{num<\d+>}", name: "deck_draw_many")]
    public function drawManyFromDeck(
        int $num,
        sessionInterface $session
    ): Response {
        $deck = $session->get("deck_obj");

        // Drawn cards.
        $drawnCardsArr = $deck->draw($num);
        $drawnCardsDeck = new Deck();
        foreach ($drawnCardsArr as $card) {
            $drawnCardsDeck->addCard($card);
        }

        $drawnCardsDeck = $drawnCardsDeck->getCardsAsString();

        $session->set("drawn_cards_deck", $drawnCardsDeck);
        $session->set("deck_obj", $deck);

        // return $this->render("card/deck_draw.html.twig", $data);
        return $this->redirectToRoute('deck_drawn');
    }

    // Session ....................................................................................
    #[Route("/session", name: "card_session")]
    public function cardSession(
        sessionInterface $session
    ): Response {
        // $session_data = [];
        // foreach ($session->all() as $session_value) {
        //     if (gettype($session_value) === "string") {
        //         $session_data[] = $session_value;
        //     } elseif (gettype($session_value) === "array") {
        //         foreach ($session_value as $item) {
        //             $session_data[] = $item;
        //         }
        //     }
        // }
        // $data = [
        //     // "session" => $session->get("session"),
        //     "session" => $session_data
        // ];

        $data = [
            'session' => $session->all()
        ];

        // var_dump($session->all());

        return $this->render("card/card_session.html.twig", $data);
    }

    // Session delete .............................................................................
    #[Route("/session/delete", name: "clear_session")]
    public function clearSession(
        sessionInterface $session
    ): Response {

        $session->clear();
        $this->addFlash(
            'notice',
            'The session has been cleared.'
        );

        return $this->redirectToRoute('card_session');
    }
}
