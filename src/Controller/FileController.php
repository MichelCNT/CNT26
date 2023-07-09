<?php

namespace App\Controller;

use App\Entity\File;
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
            'parentsFile' => []
        ]);
    }

    #[Route('/{slug}-{id}', name: 'app_file_show', requirements: ['slug' => '[a-zA-Z0-9\-]*'], methods: ['GET'])]
    public function show(File $file, FileRepository $repository): Response
    {
        $parentsFile = [];
        $actualFile = $file;
        do {
            $parent = $actualFile->getFile();
            if ($parent == null) break;
            $parentsFile[] = $parent;
            $actualFile = $parent;
        } while (true);


        return $this->render('files/index.html.twig', [
            'files' => $repository->findFilesOf($file),
            'parentsFile' => array_reverse($parentsFile),
            'actualFile' => $file
        ]);
    }
}
