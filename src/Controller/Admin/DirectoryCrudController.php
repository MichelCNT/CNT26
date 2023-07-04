<?php

namespace App\Controller\Admin;

use App\Entity\Directory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DirectoryCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Directory::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('name', 'Nom'),
            BooleanField::new('active', 'Publique ?'),
            AssociationField::new('images')
        ];
    }

}
