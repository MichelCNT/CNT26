<?php

namespace App\Controller;

use ACSEO\TypesenseBundle\Finder\TypesenseQuery;
use App\Entity\Newsletter;
use App\Repository\ArticleRepository;
use App\Repository\NewsletterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private $finder;

    public function __construct($articleFinder)
    {
        $this->finder = $articleFinder;
    }

    #[Route('/', name: 'app_index', methods: ['GET', 'POST'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('index.html.twig', [
            'whatCNT' => $articleRepository->findOneBy(['title' => 'La CNT c\'est quoi ?']),
            'manif' => $articleRepository->findOneBy(['title' => 'Les manifestations']),
            'adherer' => $articleRepository->findOneBy(['title' => 'Adhérer']),
            'carousselNews' => $articleRepository->getLatestArticle(3),
        ]);
    }

    #[Route('/search', name: 'app_search', methods: ['POST'])]
    public function search(Request $request): Response
    {
        if ($request->headers->get('hx-request')) {
            $search = $request->get('search');
            $query = new TypesenseQuery($search, 'title, shortTitle, author, category_name, text');
            $result = $this->finder->query($query)->getResults();
            return $this->render('search/index.html.twig', [
                'datas' => $result,
            ]);
        }
        throw new BadRequestHttpException();
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/newsletter', name: 'app_newsletter', methods: ['PUT'])]
    public function addNewsletterEmail(Request $request, NewsletterRepository $repository, MailerInterface $mailer): Response
    {
        $email = $request->get('email');
        $result = "";
        if ($email != null) {
            $newsletter = new Newsletter();
            $newsletter->setEmail($email);
            $result = $repository->save($newsletter, true);
            if ($result == "") {
                $mail = (new Email())
                    ->from('noreply@cnt.org')
                    ->to($email)
                    ->replyTo('contact@cnt.org')
                    ->subject('Bienvenue dans la Newsletter')
                    ->text('Je suis un test body text');
                $mailer->send($mail);
                return $this->render('componant/_form_newsletter.html.twig');
            }
        }
        return new Response(json_encode(['error' => "Adresse mail déjà enregistrée"]), 400);
    }
}
