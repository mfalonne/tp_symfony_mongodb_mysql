<?php

namespace App\Controller;

use App\Service\Book\BookManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookController extends AbstractController
{
    public function __construct(
        private BookManagerInterface $bookManager
    ) {}

    #[Route('/books', name: 'book_list')]
    public function list(): Response
    {
        $books = $this->bookManager->getAll();

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }
}
