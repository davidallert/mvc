<?php

namespace App\Controller;

// Classes
use App\Card\Deck;

// ORM
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JsonApi extends AbstractController
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


    #[Route('/api/library/books')]
    public function showLibraryJson(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        $bookArray = [];
        foreach ($books as $book) {
            $bookArray[] = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'isbn' => $book->getIsbn(),
                'author' => $book->getAuthor(),
                'image' => $book->getImage(),
            ];
        }

        $data = [
            'books' => $bookArray,
        ];

        return new JsonResponse($data);

    }

    #[Route('/api/library/book/{isbn}')]
    public function showLibraryBookJson(
        BookRepository $bookRepository,
        string $isbn
    ): Response {

        $books = $bookRepository->findAll();

        foreach ($books as $book) {

            $data = [];
            if ($book->getIsbn() === $isbn) {
                $data = [
                    'id' => $book->getId(),
                    'title' => $book->getTitle(),
                    'isbn' => $book->getIsbn(),
                    'author' => $book->getAuthor(),
                    'image' => $book->getImage(),
                ];
            };
        };

        return new JsonResponse($data);

    }
}
