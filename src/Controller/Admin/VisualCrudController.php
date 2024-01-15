<?php

namespace App\Controller\Admin;

use App\Entity\Visual;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VisualCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Visual::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('idPost'),
            TextField::new('visualName', 'Nom'),
            DateField::new('createdAt', 'Date de création')->OnlyOnIndex(),
            DateField::new('updateAt', 'Date de mise à jour')->OnlyOnIndex(),
        ];
    }
    
}
