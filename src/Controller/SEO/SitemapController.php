<?php

namespace App\Controller\SEO;

use App\Repository\ArticleRepository;
use App\Repository\FileRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapController extends AbstractController
{
    #[Route('/sitemap.xml', name: 'sitemap')]
    public function index(ArticleRepository $articleRepository, FileRepository $fileRepository)
    {
        // find published blog posts from db
        $articles = $articleRepository->findBy(['active' => 1]);
        $urls = [];
        foreach ($articles as $article) {
            $urls[] = [
                'loc' => $this->generateUrl(
                    'app_article_show',
                    [
                        'slug' => $article->getSlug(),
                        'id' => $article->getId()
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'lastmod' => ($article->getUpdatedAt() == null ? $article->getCreatedAt()->format('Y-m-d') : $article->getUpdatedAt()->format('Y-m-d')),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        $files = $fileRepository->findBy(['active' => 1]);
        foreach ($files as $file) {
            $urls[] = [
                'loc' => $this->generateUrl(
                    'app_file_show',
                    [
                        'id' => $file->getId(),
                        'slug' => $file->getSlug()
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'lastmod' => ($file->getUpdatedAt() == null ? $file->getCreatedAt()->format('Y-m-d') : $file->getUpdatedAt()->format('Y-m-d')),
                'changefreq' => 'weekly',
                'priority' => '0.4',
            ];
        }

        $urls[] = [
            'loc' => $this->generateUrl(
                'app_contact', [],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'lastmod' => (new DateTimeImmutable())->format('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.4',
        ];

        $response = new Response($this->renderView('sitemap/sitemap.html.twig', ['urls' => $urls]));
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}