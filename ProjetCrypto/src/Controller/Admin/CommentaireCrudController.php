<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Proxies\__CG__\App\Entity\Cryptomonnaie;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('cryptomonnaie')
                ->setCrudController(CryptomonnaieCrudController::class)
                ->setRequired(true)
            ,
            AssociationField::new('user')
                ->setCrudController(UserCrudController::class)
                ->setRequired(true)
            ,
            TextEditorField::new('com')
                ->setRequired(true)
            ,
        ];
    }

}
