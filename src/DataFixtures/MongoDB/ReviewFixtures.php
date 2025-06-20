<?php

namespace App\DataFixtures\MongoDB;

use App\Document\Review;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReviewFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création de 10 reviews de test
        for ($i = 1; $i <= 10; $i++) {
            $review = new Review();
            $review->setComment("Avis de test numéro $i");
            $review->setRating(rand(1, 5));

            $manager->persist($review);
        }

        $manager->flush();
    }
}
