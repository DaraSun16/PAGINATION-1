<?php

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class DashBoardProfileController extends AbstractController
{
<<<<<<< HEAD
    #[Route('/dash/board/profile', name: 'app_dash_board_profile')]
    #[IsGranted('ROLE_USER', message: 'You must be logged in to access the page.', statusCode: 404, exceptionCode: 404)]
=======
    #[Route('/dash/board/profile', name: 'app_dash_board_profile')] //1ere protection
    #[IsGranted('ROLE_USER', message: 'Je dois être connecté pour accéder à la page.', statusCode: 404, exceptionCode: 404)] //2e protection
>>>>>>> f6b961eddb15d13be96b1b12395b16e8408b7247
    public function index(): Response
    {
        return $this->render('profile/dash_board_profile/index.html.twig', [
            'controller_name' => 'DashBoardProfileController',
        ]);
    }
}
