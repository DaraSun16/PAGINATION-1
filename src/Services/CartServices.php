<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CartServices
{
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

    public function add()
    {
        return $this->requestStack->getSession();
    }
}