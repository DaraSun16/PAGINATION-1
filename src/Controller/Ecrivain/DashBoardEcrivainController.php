<?php

namespace App\Controller\Ecrivain;

<<<<<<< HEAD
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DashBoardEcrivainController extends AbstractController
{
    #[Route('/dash/board/ecrivain', name: 'app_dash_board_ecrivain')]
    #[IsGranted('ROLE_ECRIVAIN', message: 'You must be logged in to access the page.', statusCode: 404, exceptionCode: 404)]
=======
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashBoardEcrivainController extends AbstractController
{
    #[Route('/dash/board/ecrivain', name: 'app_dash_board_ecrivain')] //1ere protection
    // #[IsGranted('ROLE_ECRIVAIN', message: 'Je dois être connecté pour accéder à la page.', statusCode: 404, exceptionCode: 404)] //2e protection
>>>>>>> f6b961eddb15d13be96b1b12395b16e8408b7247
    public function index(): Response
    {
        return $this->render('ecrivain/dash_board_ecrivain/index.html.twig', [
            'controller_name' => 'DashBoardEcrivainController',
        ]);
    }
}
