<?php

namespace App\Service\Category;

use App\Entity\Category;
interface CategoryManagerInterface
{
    public function create(Category $category): Category;
    public function update(Category $category): Category;
    public function delete(Category $category): void;
    public function getAll(): array;
}
