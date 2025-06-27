<?php

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashBoardProfileController extends AbstractController
{
    #[Route('/dash/board/profile', name: 'app_dash_board_profile')]
    public function index(): Response
    {
        return $this->render('profile/dash_board_profile/index.html.twig', [
            'controller_name' => 'DashBoardProfileController',
        ]);
    }
}
