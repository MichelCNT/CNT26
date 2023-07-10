<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/publications')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $data = $articleRepository->findBy(['active' => true]);
        $view = 'article/index.html.twig';
        if ($request->headers->get('hx-request')) $view = 'article/index.htmx.twig';

        return $this->render($view, [
            'publications' => $this->makePagination($data, $paginator, $request),
        ]);
    }

    #[Route('/{slug}-{id}', name: 'app_article_show', requirements: ['slug' => '[a-zA-Z0-9\-]*'], methods: ['GET'])]
    public function show(Article $article, ArticleRepository $articleRepository): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'others' => $articleRepository->findByCategory($article->getId(), $article->getCategorie())
        ]);
    }

    private function makePagination($data, PaginatorInterface $paginator, Request $request): PaginationInterface
    {
        return $paginator->paginate($data, $request->query->getInt('page', 1), 12);
    }
}