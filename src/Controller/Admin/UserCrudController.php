<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use function PHPUnit\Framework\throwException;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('username'),
            EmailField::new('email'),
            ChoiceField::new('roles')->setChoices([
                'Divin créateur' => 'ROLE_SUPER_ADMIN',
                'Droit administrateur' => 'ROLE_ADMIN',
                'Droit de publication' => 'ROLE_PUBLICATION',
                'Aucun droit' => 'NO_ROLE'
            ])
                ->allowMultipleChoices()
                ->setPermission('ROLE_SUPER_ADMIN')->renderAsBadges(),

            TextField::new('password')->hideOnIndex()->hideOnDetail()
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) return;

        if ($this->isGranted('ROLE_ADMIN')) {
            $pass = $entityInstance->getPassword();
            $entityInstance->setPassword($this->hasher->hashPassword($entityInstance, $pass));

            if ($entityInstance->getRoles() == null) {
                $entityInstance->addRoles('NO_ROLE');
            }

            parent::persistEntity($entityManager, $entityInstance);
        }
    }
}
