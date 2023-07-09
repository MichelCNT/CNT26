<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/publications')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'publications' => $articleRepository->findBy(['active' => true]),
        ]);
    }

    #[Route('/{slug}-{id}', name: 'app_article_show', requirements: ['slug' => '[a-zA-Z0-9\-]*'], methods: ['GET'])]
    public function show(Article $article, ArticleRepository $articleRepository): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'others' => $articleRepository->findByCategory($article->getId(), $article->getCategorie(), 3)
        ]);
    }
}