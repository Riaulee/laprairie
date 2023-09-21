<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->OnlyOnIndex()->setColumns('col-md-4'),
            // TextField::new('type')->setColumns('col-md-4'),
            TextField::new('title')->setColumns('col-md-4'),
            TextField::new('subtitle')->setColumns('col-md-4'),
            TextField::new('content')->setColumns('col-md-4'),
            ImageField::new('avatar')->setColumns('col-md-4')
            ->setUploadDir('public/img/articles')
            ->setBasePath('img/articles')
            ->setSortable(false)
                ->setFormTypeOption('required', false)->setColumns('col-md-2'),
            TextField::new('email')->setColumns('col-md-4'),
            TextField::new('password')->setColumns('col-md-4'),
            DateField::new('createdAt')->OnlyOnIndex(),
            ChoiceField::new('roles')->setColumns('col-md-4')->setChoices([
                'ChantierParticipatif' => 'Chantier Participatif',
                'EvenementFutur' => 'Evénement Futur',
            ])->allowMultipleChoices(),
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
