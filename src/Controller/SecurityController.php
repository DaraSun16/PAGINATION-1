<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login', priority:10)]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
<<<<<<< HEAD
        // if the user is already authenticated, redirect to dashboard
        if ($this->getUser()) {
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin_dashboard');
            } else if ($this->isGranted('ROLE_USER')) {
                return $this->redirectToRoute('app_dash_board_profile');
            } else if ($this->isGranted('ROLE_ECRIVAIN')) {
                return $this->redirectToRoute('app_dash_board_ecrivain');
            }
            return $this->redirectToRoute('app_dash_board_profile');
        }

=======
        // if the user is already authenticated, redirect to the dashboard
        if ($this->getUser()){
            if ($this->isGranted('ROLE_ADMIN')){
                return $this->redirectToRoute('admin');
            } elseif ($this->isGranted('ROLE_USER')){
                return $this->redirectToRoute('app_dash_board_profile');
            } elseif ($this->isGranted('ROLE_ECRIVAIN')){
                return $this->redirectToRoute('app_dash_board_ecrivain');
            }
            return $this->redirectToRoute('app_dash_board_profile');
        }       
        
>>>>>>> f6b961eddb15d13be96b1b12395b16e8408b7247
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout', priority:10)]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
