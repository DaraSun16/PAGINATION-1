<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    #[Route('/{slug}', name: 'app_main_slug', requirements: ['slug' => '[a-zA-Z0-9\-]+'])]
    public function index(string $slug = null, ArticlesRepository $articlesRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $dql = $articlesRepository->findArticlesByLimitPagination($slug);

        $pagination = $paginator->paginate(
            $dql,
            $request->query->getInt('page', 1),
            12
        ); 

        return $this->render('main/index.html.twig', [
            'articles' => $pagination,
        ]);
    }
}
