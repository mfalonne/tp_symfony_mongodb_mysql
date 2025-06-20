<?php

namespace App\Repository;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use App\Document\Review;
class ReviewRepository extends DocumentRepository
{
    /**
     * Exemple : récupérer les reviews par note minimale
     */
    public function findByMinRating(int $minRating): array
    {
        return $this->createQueryBuilder()
            ->field('rating')->gte($minRating)
            ->getQuery()
            ->execute()
            ->toArray();
    }
}
