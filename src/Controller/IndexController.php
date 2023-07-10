<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Repository\ArticleRepository;
use App\Repository\NewsletterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/', name: 'app_index', methods: ['GET', 'POST'])]
    public function index(Request $request, ArticleRepository $articleRepository, NewsletterRepository $repository, MailerInterface $mailer): Response
    {
        $email = $request->get('email');
        if ($email != null) $this->addNewsletterEmail($email, $repository, $mailer);
        return $this->render('index.html.twig', [
            'whatCNT' => $articleRepository->findOneBy(['title' => 'La CNT c\'est quoi ?']),
            'nosLuttes' => $articleRepository->findOneBy(['title' => 'Nos luttes']),
            'manif' => $articleRepository->findOneBy(['title' => 'Les manifestations']),
            'adherer' => $articleRepository->findOneBy(['title' => 'Adhérer']),
            'carousselNews' => $articleRepository->getLatestArticle(3),
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function addNewsletterEmail(string $email, NewsletterRepository $repository, MailerInterface $mailer): void
    {
        $newsletter = new Newsletter();
        $newsletter->setEmail($email);
        $repository->save($newsletter, true);
        $mail = (new Email())
            ->from('noreply@cnt.org')
            ->to($email)
            ->replyTo('contact@cnt.org')
            ->subject('Bienvenue dans la Newsletter')
            ->text('Je suis un test body text');
        $mailer->send($mail);
    }
}
