<?php

namespace App\Controller\Admin;

use App\Entity\Cryptomonnaie;
use Doctrine\DBAL\Types\IntegerType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CryptomonnaieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cryptomonnaie::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('creator')
                ->setCrudController(UserCrudController::class)
                ->setRequired(true),
            IntegerField::new('MarketCap')
                ->setRequired(true),
            TextField::new('projet')
                ->setRequired(true),
            TextField::new('categorie')
                ->setRequired(true),
            IntegerField::new('price')
                ->setRequired(true),
            DateField::new('dateCreation')
                ->setRequired(true),
            TextField::new('name')
                ->setRequired(true),
            TextField::new('slug')
                ->setRequired(true),


        ];
    }

}
