<?php

namespace App\Controller\Admin;

use App\Entity\Contenu;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Visual;
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
        yield MenuItem::linkToUrl('Retour au site', 'fa fa-home', '/accueil')->setPermission('ROLE_USER');
        yield MenuItem::section('');

        // if ($this->isGranted('ROLE_USER')) {
        //     yield MenuItem::section('Gestion de mon compte');
        //     yield MenuItem::subMenu('Mon compte', 'fa fa-user-circle')->setSubItems([
        //         MenuItem::linkToCrud('Modifier mon compte', 'fas fa-eye', User::class),
        //     ]);
        // }

        // if ($this->isGranted('ROLE_EDITOR')) {
        //     yield MenuItem::section('Gestion de mes articles');
        //     yield MenuItem::subMenu('Mes événements', 'fa fa-user-circle')->setSubItems([
        //         MenuItem::linkToCrud('Créer un évenement', 'fas fa-plus-circle', Post::class)->setAction(Crud::PAGE_NEW),
        //         MenuItem::linkToCrud('Liste de mes évènements', 'fas fa-eye', Post::class),
        //     ]);
        // }

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Gestion des inscrits');
            yield MenuItem::subMenu('Utilisateurs', 'fa fa-user-circle')->setSubItems([
                MenuItem::linkToCrud('Créer un utilisateur', 'fas fa-plus-circle', User::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Liste des utilisateurs', 'fas fa-eye', User::class),
            ]);
            yield MenuItem::section('Gestion des articles');
            yield MenuItem::subMenu('Articles', 'fa fa-user-circle')->setSubItems([
                MenuItem::linkToCrud('Créer un article', 'fas fa-plus-circle', Post::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Liste des articles', 'fas fa-eye', Post::class),
                MenuItem::linkToCrud('Liste des images', 'fas fa-image', Visual::class),
            ]);
            yield MenuItem::section('Gestion de la page Qui sommes-nous?');
            yield MenuItem::subMenu('Présentation', 'fa fa-user-circle')->setSubItems([
                MenuItem::linkToCrud('Créer une section', 'fas fa-plus-circle', Contenu::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Liste des sections', 'fas fa-eye', Contenu::class),

            ]);

        }
    }
}
