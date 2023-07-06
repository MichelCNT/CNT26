<?php

namespace App\Controller;

use App\Repository\FileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/files')]
class FileController extends AbstractController
{
    #[Route('/', name: 'app_files_index')]
    public function index(FileRepository $repository): Response
    {
        return $this->render('files/index.html.twig', [
            'files' => $repository->findFirstLevel(true),
        ]);
    }

    /*    #[Route('/{slug}-{id}', name: 'app_file_show', requirements: ['slug' => '[a-zA-Z0-9\-]*'], methods: ['GET'])]
        public function show(File $directory, FileRepository $repository): Response
        {
            return $this->render('file/show.html.twig', [
                'directory' => $directory,
                'images' => $repository->findBy(['directory' => $directory]),
            ]);
        }*/
}
