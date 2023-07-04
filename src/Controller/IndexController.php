<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index', methods: ['GET', 'POST'])]
    public function index(Request $request, ArticleRepository $articleRepository): Response
    {
        $email = $request->get('email');
        if ($email != null) $this->addNewsletterEmail($email);
        return $this->render('index.html.twig', [
            'whatCNT' => $articleRepository->findOneBy(['title' => 'La CNT c\'est quoi ?']),
            'nosLuttes' => $articleRepository->findOneBy(['title' => 'Nos luttes']),
            'manif' => $articleRepository->findOneBy(['title' => 'Les manifestations']),
            'adherer' => $articleRepository->findOneBy(['title' => 'Adhérer']),
            'carousselNews' => $articleRepository->getLatestArticle(3),
        ]);
    }

    private function addNewsletterEmail(string $email)
    {
    }
}
