<?php

namespace App\Service\Book;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
class BookManager implements BookManagerInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private BookRepository $bookRepository
    ) {}

    public function getAll(): array
    {
        return $this->bookRepository->findAll();
    }

    public function getById(int $id): ?Book
    {
        return $this->bookRepository->find($id);
    }

    public function create(Book $book): Book
    {
        $this->em->persist($book);
        $this->em->flush();

        return $book;
    }

    public function update(Book $book): Book
    {

        $this->em->flush();

        return $book;
    }

    public function delete(Book $book): void
    {
        $this->em->remove($book);
        $this->em->flush();
    }

    public function getBooksByCategory(string $categoryName): array
    {
        return $this->bookRepository->findByCategory($categoryName);
    }

}
