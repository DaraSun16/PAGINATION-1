<?php

namespace App\Services;

use App\Entity\Articles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CartServices
{
    // ---------- CONSTRUCT SESSION -----------------
    public function __construct(
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager
    )
    { 
        #--# 
    }

    public function getSession()
    {
        return $this->requestStack->getSession();
    }

    // ---------- ADD PRODUCT TO PANIER -----------------
    public function add(Articles $articles)
    {
        $id = $articles->getId();

        $panier = $this->getSession()->get('panier', []);

        if ( empty($panier[$id])){
            $panier[$id] = 1; 
        } else {
            $panier[$id]++; 
        }

        $this->getSession()->set('panier', $panier);
    }

    // ---------- TOTAL PANIER 1/2 -----------------
    public function getFullcart()
    {
        $panier = $this->getSession()->get('panier', []); 

        $data = [];
        $total = 0;

        foreach ($panier as $key => $quantity) { 

            $article = $this->entityManager->getRepository(Articles::class)->find($key); 
            
            $data[] = [
                'article' => $article,
                'quantity' => $quantity,
            ];
        }

        return $data;
    }

    // ---------- TOTAL PANIER 2/2 -----------------
    public function getTotal()
    {
        $total = 0;

        foreach ( $this->getFullcart() as $item){
            $totalItem = $item['article']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $total;
    }

    // ---------- REMOVE PRODUCT TO PANIER -----------------
    public function remove(Articles $articles)
    {
        $id = $articles->getId();

        $panier = $this->getSession()->get('panier', []);

        if ( !empty($panier[$id]) ) {
            if ( $panier[$id] > 1 ) {
                $panier[$id]--;
            } else {
                unset( $panier[$id] );
            }
        }

        $this->getSession()->set('panier', $panier);
    }

    // ---------- DELETE LINE PRODUCT TO PANIER -----------------
    public function delete(Articles $articles)
    {
        $id = $articles->getId();

        $panier = $this->getSession()->get('panier', []);

        if ( !empty($panier[$id]) ) {
            unset( $panier[$id] );
        }

        $this->getSession()->set('panier', $panier);
    }
    
}