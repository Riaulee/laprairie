<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\Visual;
use App\Utils\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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

    public function configureResponseParameters(KeyValueStore $responseParameters, Request $request): KeyValueStore
    {
        $formBuilder = $this->createFormBuilder(null, ['data_class' => Visual::class]);
        $formBuilder->add('visualName');
        $formBuilder->add('file', FileType::class, [
            'label' => 'Image',
            'mapped' => false,
            'required' => true,
        ]);
        // Ajoutez d'autres champs de formulaire si nécessaire

        $form = $formBuilder->getForm();

        // Récupérer les informations du formulaire
        $form->handleRequest($request);
        $formData = $form->getData();
        $visualName = $formData['visualName'];
        $uploadedFile = $form['file']->getData();
        // Récupérez les autres champs de formulaire si nécessaire

        // Manipuler les données du formulaire
        $entityManager = $this->container->get('doctrine')->getManager();

        // Créer une nouvelle entité Visual
        $visual = new Visual();
        $visual->setVisualName($visualName);

        // Enregistrer l'entité Visual dans la base de données
        $entityManager->persist($visual);
        $entityManager->flush();

        // Traiter le fichier téléchargé
        if ($uploadedFile) {
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename . '.' . $uploadedFile->guessExtension();

            // Déplacez le fichier téléchargé vers le répertoire de votre choix
            $uploadedFile->move(
                $this->getParameter('upload_directory'),
                $newFilename
            );

            // Ajouter l'emplacement du fichier à l'entité Visual
            $visual->setFilePath($newFilename);

            // Enregistrer les modifications de l'entité Visual dans la base de données
            $entityManager->flush();
        }

        return parent::configureResponseParameters($responseParameters);
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
            ImageField::new('visuals')->setColumns('col-md-7'),
            // ->setUploadDir('public/img/articles')
            // ->setBasePath('img/avatar')
            // ->setSortable(false)
            // ->setFormTypeOption('required',false)->setColumns('col-md-7'),
            DateField::new('createdAt', 'Date de création')->OnlyOnIndex(),
            DateField::new('updateAt', 'Date de mise à jour')->OnlyOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }
   
}
