<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),
            TextField::new('shortTitle', 'Titre court'),
            TextField::new('author', 'Auteurice')->onlyWhenCreating(),
            AssociationField::new('categorie', 'Catégorie'),
            TextField::new('author', 'Auteurice')->setPermission('ROLE_ADMIN'),
            TextEditorField::new('text', 'Texte'),
            ImageField::new('coverImage', 'Image de couverture')
                ->setBasePath(Article::UPLOAD_IMAGES_BASE_PATH)
                ->setUploadDir(Article::UPLOAD_PATH_COMPLETE)
                ->setRequired(false),
            BooleanField::new('active', 'Publier')->setPermission('ROLE_ADMIN'),
            DateTimeField::new('createdAt', 'Date de création')->hideOnForm(),
            DateTimeField::new('updatedAt', 'Date de mise à jour')->hideOnForm(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Article) return;

        $entityInstance->setCreatedAt(new DateTimeImmutable());

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Article) return;

        $entityInstance->setUpdatedAt(new DateTimeImmutable());

        parent::updateEntity($entityManager, $entityInstance);
    }
}
