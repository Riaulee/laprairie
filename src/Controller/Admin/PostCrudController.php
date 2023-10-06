<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\VisualType;
use App\Utils\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Form\FormFactoryInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{
    
    private FileUploader $fileUploader;
    private $formFactory;

    public function __construct(FileUploader $fileUploader, FormFactoryInterface $formFactory)
    {
        $this->fileUploader = $fileUploader;
        $this->formFactory = $formFactory;
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
            IdField::new('id')->HideOnForm(),
            // TextField::new('type')->setColumns('col-md-7'),
            TextField::new('title', 'Titre')->setColumns('col-md-7'),
            TextField::new('subtitle','Sous-titre')->setColumns('col-md-7'),
            TextareaField::new('content', 'Contenu')
            ->setFormType(CKEditorType::class)
            ->setColumns('col-md-7')
            ->hideOnIndex(),
            AssociationField::new('idUser')->OnlyOnIndex(),
            CollectionField::new('visuals')->setColumns('col-md-7')
            ->setEntryType(VisualType::class)
            // ->setUploadDir('public/img/articles')
            // ->setBasePath('img/avatar')
            // ->setSortable(false)
            ->setFormTypeOption('required',false),
            DateField::new('createdAt', 'Date de création')->OnlyOnIndex(),
            DateField::new('updateAt', 'Date de mise à jour')->OnlyOnIndex(),
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
