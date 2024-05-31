<?php

namespace App\Controller\Admin;

use App\Entity\Contenu;
use App\Form\VisualType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use App\Utils\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


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
            AssociationField::new('users', 'Auteur(e)')->OnlyOnIndex(),
            ImageField::new('image', 'Image')->setColumns('col-md-7')
            ->setUploadDir('public/img/contenu')
            ->setBasePath('img/contenu')
            ->setSortable(false)
            ->setFormTypeOption('required',false),
            DateField::new('createdAt', 'Date de création')->OnlyOnIndex(),
            DateField::new('updateAt', 'Date de mise à jour')->OnlyOnIndex(),
            IntegerField::new('ponderation', 'Position article')->setColumns('col-md-7'),
            TextField::new('positionImage', 'Position de l\'image')->setColumns('col-md-7'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }

}
