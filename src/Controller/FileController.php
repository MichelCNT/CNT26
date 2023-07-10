<?php

namespace App\Controller;

use App\Entity\File;
use App\Repository\FileRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/files')]
class FileController extends AbstractController
{
    #[Route('/', name: 'app_files_index')]
    public function index(FileRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $view = 'files/index.html.twig';
        if ($request->headers->get('hx-request')) {
            $view = 'files/index.htmx.twig';
        }
        return $this->render($view, [
            'files' => $this->makePagination($repository->findFirstLevel(true), $paginator, $request),
            'parentsFile' => []
        ]);
    }

    #[Route('/{slug}-{id}', name: 'app_file_show', requirements: ['slug' => '[a-zA-Z0-9\-]*'], methods: ['GET'])]
    public function show(File $file, FileRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $parentsFile = [];
        $actualFile = $file;
        do {
            $parent = $actualFile->getFile();
            if ($parent == null) break;
            $parentsFile[] = $parent;
            $actualFile = $parent;
        } while (true);

        $view = 'files/index.html.twig';
        if ($request->headers->get('hx-request')) {
            $view = 'files/index.htmx.twig';
        }

        return $this->render($view, [
            'files' => $this->makePagination($repository->findFilesOf($file), $paginator, $request),
            'parentsFile' => array_reverse($parentsFile),
            'actualFile' => $file
        ]);
    }

    private function makePagination($data, PaginatorInterface $paginator, Request $request): PaginationInterface
    {
        return $paginator->paginate($data, $request->query->getInt('page', 1), 12);
    }
}
