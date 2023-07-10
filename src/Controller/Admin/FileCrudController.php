<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\File;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return File::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom du fichier'),
            BooleanField::new('active', 'Activé ?'),
            AssociationField::new('files', 'Fichiers')->hideOnForm(),
            AssociationField::new('file', 'Fichier parent')->setRequired(false),
            ImageField::new('filePath', 'Contenu')
                ->setBasePath(Article::UPLOAD_IMAGES_BASE_PATH)
                ->setUploadDir(Article::UPLOAD_PATH_COMPLETE)
                ->setRequired(false),
            DateTimeField::new('createdAt', 'Date de création')->hideOnForm(),
            DateTimeField::new('updatedAt', 'Date de mise à jour')->hideOnForm(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof File) return;

        $entityInstance->setCreatedAt(new DateTimeImmutable());

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof File) return;

        $entityInstance->setUpdatedAt(new DateTimeImmutable());

        parent::updateEntity($entityManager, $entityInstance);
    }
}
