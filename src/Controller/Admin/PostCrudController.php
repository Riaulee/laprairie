<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Utils\FileUploader;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{
    
    private FileUploader $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }


    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $post = new Post();
        $post->setIdUser($this->getUser());

        return $post;
    }

    public function configureFields($pageName): iterable
    {
        return [
            AssociationField::new('fkposttype','Type d\'évenement')->setColumns('col-md-7'),
            IdField::new('id')->OnlyOnIndex()->setColumns('col-md-7'),
            // TextField::new('type')->setColumns('col-md-7'),
            TextField::new('title', 'Titre')->setColumns('col-md-7'),
            TextField::new('subtitle','Sous-titre')->setColumns('col-md-7'),
            CodeEditorField::new('content', 'Contenu')->hideOnIndex()->setColumns('col-md-7')
            ->setNumOfRows(10)->setLanguage('markdown', 'html')
            ->setHelp('Utilisez les laguages Markdown et HTML pour formater le contenu de l\'actualité. '),
            AssociationField::new('idUser')->OnlyOnIndex(),
            //ImageField::new('visuals')->setColumns('col-md-7'),
            DateField::new('createdAt', 'Date de création')->OnlyOnIndex(),
            DateField::new('updateAt', 'Date de mise à jour')->OnlyOnIndex(),
        ];
    }

   
}
