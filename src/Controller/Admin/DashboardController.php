<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Contact;
use App\Entity\File;
use App\Entity\Newsletter;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
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

        yield MenuItem::Section('Fichiers',);
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajout de fichier', 'fas fa-plus', File::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les fichiers', 'fas fa-eye', File ::class)
        ]);

        yield MenuItem::section('Contacts');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
//            MenuItem::linkToCrud('Modification des informations', 'fa-solid fa-pen-to-square', Contact::class)->setAction(Crud::PAGE_EDIT),
            MenuItem::linkToCrud('Voir les informations', 'fas fa-eye', Contact::class)
        ]);

        yield MenuItem::section('Newsletter');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajout une adresse', 'fa-solid fa-pen-to-square', Newsletter::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les adresses', 'fas fa-eye', Newsletter::class)
        ]);

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Utilisateur.ices');
            yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
                MenuItem::linkToCrud('Ajout d\'un compte', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Voir les comptes', 'fas fa-eye', User::class)
            ]);
        }
    }
}
