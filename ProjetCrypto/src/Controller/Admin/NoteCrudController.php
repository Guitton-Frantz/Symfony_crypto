<?php

namespace App\Controller\Admin;

use App\Entity\Note;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class NoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Note::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user')
                ->setCrudController(UserCrudController::class)
                ->setRequired(true),
            AssociationField::new('crypto')
                ->setCrudController(CryptomonnaieCrudController::class)
                ->setRequired(true),
            TextEditorField::new('contenu'),
        ];
    }

}
