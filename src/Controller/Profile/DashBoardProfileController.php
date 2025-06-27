<?php

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class DashBoardProfileController extends AbstractController
{
    #[Route('/dash/board/profile', name: 'app_dash_board_profile')]
    #[IsGranted('ROLE_USER', message: 'You must be logged in to access the page.', statusCode: 404, exceptionCode: 404)]
    public function index(): Response
    {
        return $this->render('profile/dash_board_profile/index.html.twig', [
            'controller_name' => 'DashBoardProfileController',
        ]);
    }
}
