<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
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
            IdField::new('id')->OnlyOnIndex()->setColumns('col-md-4'),
            TextField::new('firstName')->setColumns('col-md-4'),
            TextField::new('lastName')->setColumns('col-md-4'),
            ImageField::new('avatar')->setColumns('col-md-4')
            ->setUploadDir('public/img/avatar')
            ->setBasePath('img/avatar')
            ->setSortable(false)
            ->setFormTypeOption('required',false)->setColumns('col-md-2'),
            TextField::new('email')->setColumns('col-md-4'),
            TextField::new('password')->setColumns('col-md-4'),
            DateField::new('createdAt')->OnlyOnIndex(),
            ChoiceField::new('roles')->setColumns('col-md-4')->setChoices([
                'ROLE_USER' => 'ROLE_USER',
                'ROLE_EDITOR' => 'ROLE_EDITOR',
                'ROLE_ADMIN' => 'ROLE_ADMIN',
            ])->allowMultipleChoices(),
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

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }

    public function newAction(EntityManagerInterface $entityManager, Request $request): Response
{
    $user = new User();
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Hash the password
        $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        // ...
    }

    // ...
}

public function editAction(EntityManagerInterface $entityManager, Request $request): Response
{
    $user = $this->getDoctrine()->getRepository(User::class)->find($id);

    if (!$user) {
        throw $this->createNotFoundException('User not found');
    }

    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Hash the password if it has been changed
        if ($user->getPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
        }

        $entityManager->flush();

        // ...
    }
}

}