<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email')
                ->setRequired(true),
            TextField::new('password')
                ->setRequired(true),
            TextField::new('pseudo')
                ->setRequired(true),
            ChoiceField::new('roles')
                ->allowMultipleChoices(true)
                ->setChoices([
                    'user' => "ROLE_USER",
                    'admin' => "ROLE_ADMIN"
                ])
                ->setRequired(true),
        ];
    }

}
