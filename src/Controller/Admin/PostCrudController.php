<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\Visual;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields($pageName): iterable
    {
        return [
            IdField::new('id')->OnlyOnIndex()->setColumns('col-md-4'),
            // TextField::new('type')->setColumns('col-md-4'),
            TextField::new('title')->setColumns('col-md-4'),
            TextField::new('subtitle')->setColumns('col-md-4'),
            TextField::new('content')->setColumns('col-md-4'),
            // CollectionField::new('visuals')->setEntryType(Visual::class)->setColumns('col-md-4'),
            DateField::new('createdAt')->OnlyOnIndex(),
            $pageName->setUser('idUser'),
        ];
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
