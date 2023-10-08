<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('Admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration')
            ->setLocales(['fr'])
            ->setTranslationDomain('admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Retour au site', 'fa fa-home', '/')->setPermission('ROLE_USER');
        yield MenuItem::section('');

        if ($this->isGranted('ROLE_USER')) {
            yield MenuItem::section('Gestion de mon compte');
            yield MenuItem::subMenu('Mon compte', 'fa fa-user-circle')->setSubItems([
                MenuItem::linkToCrud('Modifier mon compte', 'fas fa-eye', User::class),
            ]);
        }

        if ($this->isGranted('ROLE_EDITOR')) {
            yield MenuItem::section('Gestion de mes articles');
            yield MenuItem::subMenu('Mes événements', 'fa fa-user-circle')->setSubItems([
                MenuItem::linkToCrud('Créer un évenement', 'fas fa-plus-circle', Post::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Liste de mes évènements', 'fas fa-eye', Post::class),
            ]);
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Gestion des inscrits');
            yield MenuItem::subMenu('Utilisateurs', 'fa fa-user-circle')->setSubItems([
                MenuItem::linkToCrud('Créer un utilisateur', 'fas fa-plus-circle', User::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Liste des utilisateurs', 'fas fa-eye', User::class),
            ]);
            yield MenuItem::section('Gestion des articles');
            yield MenuItem::subMenu('Evénements', 'fa fa-user-circle')->setSubItems([
                MenuItem::linkToCrud('Créer un évenement', 'fas fa-plus-circle', Post::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Liste des évènements', 'fas fa-eye', Post::class),
            ]);
        }
    }
}
