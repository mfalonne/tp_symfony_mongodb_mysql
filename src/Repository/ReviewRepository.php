<?php

namespace App\Repository;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use App\Document\Review;
class ReviewRepository extends DocumentRepository
{
    /**
     * Récupérer les reviews par note minimale
     */
    public function findByMinRating(int $minRating): array
    {
        return $this->createQueryBuilder()
            ->field('rating')->gte($minRating)
            ->getQuery()
            ->execute()
            ->toArray();
    }

    /**
     * Calcul la moyenne des Ratings
     */
    public function getAverageRating(): ?float
    {
        $aggregation = $this->createAggregationBuilder();

        $result = $aggregation
            ->group()
            ->field('_id')->expression(null)
            ->field('average')->avg('$rating')
            ->execute()
            ->toArray();

        return isset($result[0]['average']) ? round($result[0]['average'], 2) : null;
    }
}
