<?php

namespace App\Service\Review;


use App\Document\Review;
interface ReviewManagerInterface
{
    public function create(Review $review): Review;
    public function update(Review $review): Review;
    public function delete(Review $review): void;
    public function findAll(): array;

}
