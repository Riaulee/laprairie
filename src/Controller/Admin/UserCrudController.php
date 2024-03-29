<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Utils\ImageOptimizer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstName', 'Nom')->setColumns('col-md-7'),
            TextField::new('lastName', 'Prénom')->setColumns('col-md-7'),
            TextField::new('pseudo', 'Pseudonyme')->setColumns('col-md-7'),
            ImageField::new('avatar', 'Avatar')->setColumns('col-md-7')
            ->setUploadDir('public/img/avatar')
            ->setBasePath('img/avatar')
            ->setSortable(false)
            ->setFormTypeOption('required',false)->setColumns('col-md-7'),
            EmailField::new('email', 'Adresse mail')->setColumns('col-md-7'),
            TextField::new('password', 'Mot de passe')->setColumns('col-md-7')->HideOnIndex(),
            DateField::new('createdAt', 'Date de création')->OnlyOnIndex(),
            DateField::new('updateAt', 'Date de mise à jour')->OnlyOnIndex(),
            ChoiceField::new('roles')->setColumns('col-md-7')->setChoices([
                'ROLE_USER' => 'ROLE_USER',
                'ROLE_EDITOR' => 'ROLE_EDITOR',
                'ROLE_ADMIN' => 'ROLE_ADMIN',
            ])->allowMultipleChoices()->hideOnIndex(),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('roles');
    }

//     public function configureActions(Actions $actions): Actions
//     {
//         return $actions
//             ->setPermission(Action::DELETE, 'ROLE_ADMIN');
//     }

//     public function newAction(EntityManagerInterface $entityManager, Request $request): Response
//     {
//         $user = new User();
//         $form = $this->createForm(User::class, $user);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             // Hash the password
//             $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
//             $user->setPassword($hashedPassword);

//             $entityManager->persist($user);
//             $entityManager->flush();

//             // Resize and save the image
//             $avatarFile = $form['avatar']->getData();
//             if ($avatarFile instanceof UploadedFile) {
//                 $targetFilename = $this->resizeAndSaveImage($avatarFile);
//                 $user->setAvatar($targetFilename);
//                 $entityManager->flush();
//         }
//     }

//         return new Response();
// }

    // public function editAction(EntityManagerInterface $entityManager, Request $request, $id): Response
    // {
    //     $user = $entityManager->getRepository(User::class)->find($id);

    //         if (!$user) {
    //             throw $this->createNotFoundException('Utilisateur non trouvé');
    //         }

    //         $form = $this->createForm(User::class, $user);
    //         $form->handleRequest($request);

    //         if ($form->isSubmitted() && $form->isValid()) {
    //             // Hash the password if it has been changed
    //             if ($user->getPassword()) {
    //                 $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
    //                 $user->setPassword($hashedPassword);
    //             }

    //         // Resize and save the image if a new image file is uploaded
    //         $avatarFile = $form['avatar']->getData();
    //         if ($avatarFile instanceof UploadedFile) {
    //             $targetFilename = $this->resizeAndSaveImage($avatarFile);
    //             $user->setAvatar($targetFilename); 
    //         }

    //             $entityManager->flush();

    //         }
    //     return new Response();
    // }


    // private function resizeAndSaveImage(UploadedFile $file): string
    // {
    //         $targetDirectory = $this->getParameter('photo_avatar'); // Chemin du répertoire d'enregistrement des images
    //         $targetFilename = md5(uniqid()) . '.' . $file->guessExtension(); // Génère un nom de fichier unique

    //         $filePath = $file->move($targetDirectory, $targetFilename)->getPathname(); // Enregistre l'image dans le répertoire cible

    //         // Redimensionne l'image en utilisant la classe ImageOptimizer
    //         $imageOptimizer = new ImageOptimizer();
    //         $imageOptimizer->resize($filePath);

    //         // Réduit la taille du fichier à 2 MiB maximum
    //         $maxFileSize = 2 * 1024 * 1024; // 2 MiB
    //         if (filesize($filePath) > $maxFileSize) {
    //             $imageOptimizer->resize($filePath, $maxFileSize);
    //         }

    //         return $targetFilename; // Retourne le nom du fichier enregistré
    // }


    }