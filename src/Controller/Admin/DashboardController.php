<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Directory;
use App\Entity\Image;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(ArticleCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CNT');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Acceuil', 'fa fa-home');

        yield MenuItem::section('Publications');
        yield MenuItem::subMenu('Actions',  'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajout de publication', 'fas fa-plus', Article::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les publications', 'fas fa-eye', Article::class)
        ]);

        yield MenuItem::section('Catégories');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajout de catégorie', 'fas fa-plus', Categorie::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les catégories', 'fas fa-eye', Categorie ::class)
        ]);

        yield MenuItem::section('Gallerie');
        yield MenuItem::subMenu('Dossiers', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajout de dossiers', 'fas fa-plus', Directory::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les dossiers', 'fas fa-eye', Directory ::class)
        ]);
        yield MenuItem::subMenu('Photos', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajout d\'images', 'fas fa-plus', Image::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les images', 'fas fa-eye', Image ::class)
        ]);

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Utilisateurices');
            yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
                MenuItem::linkToCrud('Ajout d\'un compte', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Voir les comptes', 'fas fa-eye', User::class)
            ]);
        }
    }
}
