<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
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
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextField::new('shortTitle'),
            TextField::new('author'),
            AssociationField::new('categorie'),
            TextEditorField::new('text'),
            ImageField::new('coverImage')
                ->setBasePath(Article::ARTICLE_BASE_PATH)
                ->setUploadDir(Article::ARTICLE_UPLOAD_PATH),
            DateTimeField::new('createdAt')->hideOnForm(),
            DateTimeField::new('updatedAt')->hideOnForm(),
        ];
    }

    /**
     * @throws \Exception
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Article) return;

        if ($entityInstance->getCreatedAt() == null) {
            $entityInstance->setCreatedAt(new \DateTimeImmutable());
        } else $entityInstance->setUpdatedAt(new \DateTimeImmutable());

        parent::persistEntity($entityManager, $entityInstance);
    }


}
