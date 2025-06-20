<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Service\Book\BookManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    public function __construct(
        private BookManagerInterface $bookManager,
        private EntityManagerInterface $em // injecte aussi l'EntityManager
    ) {}

    #[Route('/books', name: 'book_list')]
    public function list(Request $request): Response
    {
        $filters = [
            'titre' => $request->query->get('titre'),
            'auteur' => $request->query->get('auteur'),
            'categorie' => $request->query->get('categorie'),
        ];

        $books = $this->bookManager->getAll($filters); // si tu veux filtrer

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'filters' => $filters,
        ]);
    }

    #[Route('/books/new', name: 'book_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $book = new Book();

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($book);
            $em->flush();

            $this->addFlash('success', 'Livre ajouté avec succès.');

            return $this->redirectToRoute('book_list');
        }

        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/books/{id}', name: 'book_show')]
    public function show(int $id): Response
    {
        $book = $this->bookManager->getById($id);

        if (!$book) {
            throw $this->createNotFoundException('Livre non trouvé.');
        }

        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }


    #[Route('/books/{id}/edit', name: 'book_edit')]
    public function edit(Book $book, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Livre modifié avec succès.');

            return $this->redirectToRoute('book_list');
        }

        return $this->render('book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book,
        ]);
    }

    #[Route('/book/{id}', name: 'book_delete', methods: ['POST', 'DELETE'])]
    public function delete(Request $request, Book $book): RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
            $this->em->remove($book);
            $this->em->flush();

            $this->addFlash('success', 'Livre supprimé avec succès.');
        }

        return $this->redirectToRoute('book_list');
    }
}
