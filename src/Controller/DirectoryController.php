<?php

namespace App\Controller;

use App\Entity\Directory;
use App\Repository\DirectoryRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DirectoryController extends AbstractController
{
    #[Route('/directory', name: 'app_directory')]
    public function index(DirectoryRepository $repository): Response
    {
        return $this->render('gallery/directory/index.html.twig', [
            'dossiers' => $repository->findBy(['active' => true]),
        ]);
    }

    #[Route('/{slug}-{id}', name: 'app_directory_show', requirements: ['slug' => '[a-zA-Z0-9\-]*'], methods: ['GET'])]
    public function show(Directory $directory, ImageRepository $repository): Response
    {
        return $this->render('gallery/directory/show.html.twig', [
            'directory' => $directory,
            'images' => $repository->findBy(['directory' => $directory]),
        ]);
    }
}
