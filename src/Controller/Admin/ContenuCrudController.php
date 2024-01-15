<?php

namespace App\Controller\Admin;

use App\Entity\Contenu;
use App\Form\VisualType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContenuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contenu::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->HideOnForm(),
            TextField::new('title', 'Titre')->setColumns('col-md-7'),
            //TextField::new('subtitle','Sous-titre')->setColumns('col-md-7'),
            TextareaField::new('content', 'Contenu')
            ->setFormType(CKEditorType::class)
            ->setColumns('col-md-7')
            ->hideOnIndex(),
            AssociationField::new('users')->OnlyOnIndex(),
            ImageField::new('image')->setColumns('col-md-7')
            ->setUploadDir('public/img/site'),
            DateField::new('createdAt', 'Date de création')->OnlyOnIndex(),
            DateField::new('updateAt', 'Date de mise à jour')->OnlyOnIndex(),
            IntegerField::new('ponderation', 'Position article')->setColumns('col-md-7'),
            TextField::new('positionImage', 'Position de l\'image')->setColumns('col-md-7'),
        ];
    }

}
