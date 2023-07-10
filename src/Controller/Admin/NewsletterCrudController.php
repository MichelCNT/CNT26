<?php

namespace App\Controller\Admin;

use App\Entity\Newsletter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

class NewsletterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Newsletter::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email', 'Adresse mail'),
        ];
    }

}
