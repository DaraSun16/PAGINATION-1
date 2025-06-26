<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Articles;
use Stripe\Checkout\Session;
use App\Services\CartServices;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    // ---------- PAIEMENT -----------------
    #[Route('/payement', name: 'payement', priority: 10)]
    public function payement(){
        $stripeSk = $_ENV['STRIPE_SK'];
        Stripe::setApiKey($stripeSk);

        // $takeRate = \Stripe\TaxRate::create([
        //     'display_name'=>'tva',
        //     'inclusive'=>false,
        //     //true :
        //     //false : TVA en plus
        //     'percentage'=>20.0,
        //     'country'=>'FR',
        // ]);

        $lineItems = [];

        foreach ( $this->cartServices->getFullcart() as $product )
        {
            $lineItems[] = [
                'price_data'=>[
                    'currency'=>'eur', 
                    'unit_amount'=>$product['article']->getPrice()*100,
                    'product_data'=>[
                        'name'=>$product['article']->getTitle(),
                        'description'=>'description par defaut',
                    ],
                ],
                'quantity'=>$product['quantity'],
                // 'taxe_rates'=>[$takeRate->id],
            ];

        }

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types'=>['card', 'sepa_debit'],
            'line_items'=>$lineItems,
            'mode'=>'payment',
            'success_url'=>'https://127.0.0.1:8000/cart/success?session_id={CHECKOUT_SESSION_ID}', //$this->generateUrl('app_success_url', [], UrlGeneratorInterface::ABSOLUTE_URL)
            'cancel_url'=>$this->generateUrl('app_cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);
    }

    // ---------- SUCCESS -----------------
    #[Route('/success', name: 'success_url', priority: 10)]
    public function success(Request $request){
        $sessionId = $request->query->get('session_id');
        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SK']);
        $session = $stripe->checkout->session->retrieve($sessionId);
        $payment = $stripe->paymentIntents->retrieve($session->payment_intent);
        $customer = $stripe->customer->retrieve($payment->customer);
    }

    // ---------- CANCEL -----------------
    #[Route('/cancel_url', name: 'cancel_url', priority: 10)]
    public function cancel(){
        
    }
}
