<?php

namespace App\Service\Review;

use App\Document\Review;
use App\Repository\ReviewRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
class ReviewManager implements ReviewManagerInterface
{
    public function __construct(private DocumentManager $dm) {}

    public function create(Review $review): Review
    {
        $this->dm->persist($review);
        $this->dm->flush();
        return $review;
    }

    public function update(Review $review): Review
    {
        $this->dm->flush();
        return $review;
    }

    public function delete(Review $review): void
    {
        $this->dm->remove($review);
        $this->dm->flush();
    }

    public function findAll(): array
    {
        return $this->dm->getRepository(Review::class)->findAll();
    }
}
