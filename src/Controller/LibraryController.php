<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }

    #[Route('/library/create', name: 'library_create', methods: ['GET', 'POST'])]
    public function createBookForm(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {

        if ($request->isMethod('POST')) {
            $entityManager = $doctrine->getManager();

            $book = new Book();
            $book->setTitle($request->get('title'));
            $book->setAuthor($request->get('author'));
            $book->setIsbn($request->get('isbn'));
            $book->setImage($request->get('image'));

            $entityManager->persist($book);

            $entityManager->flush();
        }

        return $this->render('library/create.html.twig');
    }

    #[Route('/library/show', name: 'library_read_all')]
    public function showLibrary(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        $data = [
            "library" => $books,
        ];

        return $this->render('library/read_all.html.twig', $data);
    }

    #[Route('/library/show/{id}', name: 'library_read_one')]
    public function showBookById(
        bookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        $data = [
            'book' => $book
        ];

        return $this->render('library/read_one.html.twig', $data);

    }

    #[Route('/library/update/{id}', name: 'book_update', methods: ['GET', 'POST'])]
    public function updateBook(
        ManagerRegistry $doctrine,
        Request $request,
        int $id
    ): Response {

        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        if ($request->isMethod('POST')) {

            $book->setTitle($request->get('title'));
            $book->setAuthor($request->get('author'));
            $book->setIsbn($request->get('isbn'));
            $book->setImage($request->get('image'));

            $entityManager->flush();

            return $this->redirectToRoute('library_read_all');
        }

        $data = [
            'book' => $book
        ];

        return $this->render('library/update.html.twig', $data);
    }

    #[Route('/library/delete/{id}', name: 'book_delete')]
    public function deleteBookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('library_read_all');
    }


    // #[Route('/book/view', name: 'book_view_all')]
    // public function viewAllbook(
    //     bookRepository $bookRepository
    // ): Response {
    //     $books = $bookRepository->findAll();

    //     $data = [
    //         'books' => $books
    //     ];

    //     return $this->render('book/view.html.twig', $data);
    // }

    //     #[Route('/book/view/{value}', name: 'book_view_minimum_value')]
    //     public function viewbookWithMinimumValue(
    //         bookRepository $bookRepository,
    //         int $value
    //     ): Response {
    //         $books = $bookRepository->findByMinimumValue($value);

    //         $data = [
    //             'books' => $books
    //         ];

    //         return $this->render('book/view.html.twig', $data);
    //     }

    //     #[Route('/book/show/min/{value}', name: 'book_by_min_value')]
    //     public function showbookByMinimumValue(
    //         bookRepository $bookRepository,
    //         int $value
    //     ): Response {
    //         $books = $bookRepository->findByMinimumValue2($value);

    //         return $this->json($books);
    //     }
}
