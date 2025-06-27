<?php

namespace App\Controller\Ecrivain;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashBoardEcrivainController extends AbstractController
{
    #[Route('/dash/board/ecrivain', name: 'app_dash_board_ecrivain')]
    public function index(): Response
    {
        return $this->render('ecrivain/dash_board_ecrivain/index.html.twig', [
            'controller_name' => 'DashBoardEcrivainController',
        ]);
    }
}
