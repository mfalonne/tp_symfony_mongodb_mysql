<?php

namespace App\Controller;

use App\Service\User\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    public function __construct(
        private UserManagerInterface $userManager
    ) {}

    #[Route('/users', name: 'user_list')]
    public function list(): Response
    {
        $users = $this->userManager->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
