<?php

namespace App\Service\Book;

use App\Entity\Book;

interface BookManagerInterface
{
    public function getAll(): array;
    public function getById(int $id): ?Book;
    public function create(Book $book): Book;
    public function update(Book $book): Book;
    public function delete(Book $book): void;
    public function getBooksByCategory(string $categoryName): array;
}
