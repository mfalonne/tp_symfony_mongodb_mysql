<?php

namespace App\Controller;

use App\Document\Review;
use App\Service\Review\ReviewManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class ReviewController extends AbstractController
{
    public function __construct(private ReviewManagerInterface $reviewManager)
    {
    }

    #[Route('/reviews', name: 'review_list')]
    public function list(Request $request): Response
    {
        $minRating = (int) $request->query->get('minRating', 0);
        if ($minRating > 0) {
            $reviews = $this->reviewManager->findByMinRating($minRating);
        } else {
            // Ici, si tu veux, tu peux ajouter une méthode findAll() dans ReviewManager
            $reviews = $this->reviewManager->findByMinRating(0); // affiche tout
        }

        return $this->render('review/list.html.twig', [
            'reviews' => $reviews,
            'minRating' => $minRating,
        ]);
    }

    #[Route('/review/create', name: 'review_create')]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $content = $request->request->get('content');
            $rating = (int) $request->request->get('rating');
            $review = new Review();
            $review->setContent($content);
            $review->setRating($rating);
            $review->setCreatedAt(new \DateTime());

            $this->reviewManager->create($review);

            return $this->redirectToRoute('review_list');
        }

        return $this->render('review/create.html.twig');
    }
}
