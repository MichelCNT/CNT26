<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $email = $request->get('email');
        if ($email != null) $this->addNewsletterEmail($email);
        return $this->render('index.html.twig');
    }

    #[Route('/la-cnt', name: 'app_la_cnt')]
    public function la_cnt(Request $request): Response
    {
        return $this->render('la-cnt.html.twig');
    }

    private function addNewsletterEmail(string $email)
    {
    }
}
