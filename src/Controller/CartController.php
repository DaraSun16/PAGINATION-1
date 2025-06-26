<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use App\Services\CartServices;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/cart', name: 'app_')] // This route prefix will be used for all routes in this controller
final class CartController extends AbstractController
{
    public function __construct( private CartServices $cartServices ) 
    { 
        #--#
    }

    // ---------- ADD PRODUCT TO PANIER -----------------
    #[Route('/cart/{id}', name: 'cart')] // This route will match /cart/{id} and use the name 'app_cart' with concatenated prefix
    public function add(Articles $articles): Response // + SessionInterface $session dans les parantheses
    {
        // $id = $articles->getId();
        // $panier = $this->getSession()->get('panier', []);
        // if ( empty($panier[$id])){ 
        //     $panier[$id] = 1; // 1 = quantity add 1 by 1
        // } else {
        //     $panier[$id]++; 
        // }
        // // $panier[$id] = ( empty ($pannier[$id]) ? 1 : $panier[$id]+1 ); en terme ternaire
        // $this->getSession()->set('panier', $panier);
        // Deplacer dans CartServices.php

        $this->cartServices->add($articles);

        return $this->redirectToRoute('app_index');
    }

    // ---------- TOTAL PANIER -----------------
    #[Route('/', name: 'index')]
    public function index() // SessionInterface $session, ArticlesRepository $articlesRepository entre parantheses
    {
        // $panier = $session->get('panier', []); // Retrieve session panier
        // $data = [];
        // $total = 0;
        // foreach ($panier as $key => $quantity) { //$id if promblem
        //     $article = $articlesRepository->find($key); //$id if promblem
        //     $data[] = [
        //         'article' => $article,
        //         'quantity' => $quantity,
        //     ];
        //     $total += $article->getPrice() * $quantity;
        // }
        // Deplacer dans CartServices.php

        return $this->render('cart/cart.html.twig', [
            'data' => $this->cartServices->getFullcart(), // $data à la place de $this
            'total' => $this->cartServices->getTotal(), // $total à la place de $this
        ]);
    }

    // ---------- REMOVE PRODUCT TO PANIER -----------------
    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Articles $articles, SessionInterface $session)
    {
        // $id = $articles->getId();
        // $panier = $session->get('panier', []);
        // if ( !empty($panier[$id]) ) {
        //     if ( $panier[$id] > 1 ) {
        //         $panier[$id]--;
        //     } else {
        //         //mettre un overlay pour être sur que le client ne veuille plus du produit
        //         unset( $panier[$id] );
        //     }
        // }
        // $session->set('panier', $panier);
        // déplacer dans CartServices.php

        $this->cartServices->remove($articles); // ligne ajouter

        return $this->redirectToRoute('app_index');
    }

    // ---------- DELETE LINE PRODUCT TO PANIER -----------------
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Articles $articles, SessionInterface $session)
    {
        // $id = $articles->getId();

        // $panier = $session->get('panier', []);

        // if ( !empty($panier[$id]) ) {
        //     unset( $panier[$id] );
        // }

        // $session->set('panier', $panier);
        // Deplacer dans CartServices.php

        $this->cartServices->delete($articles); // ligne ajouter

        return $this->redirectToRoute('app_index');
    }

    // ---------- EMPTY TO PANIER -----------------
    #[Route('/empty', name: 'empty', priority: 10)]
    public function empty(SessionInterface $session)
    {
        $session->remove('panier');

        return $this->redirectToRoute('app_index');
    }
}
