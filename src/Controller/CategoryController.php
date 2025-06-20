<?php

namespace App\Controller;

use App\Service\Category\CategoryManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryManagerInterface $categoryManager
    ) {}

    #[Route('/categories', name: 'category_list')]
    public function list(): Response
    {
        $categories = $this->categoryManager->getAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
