<?php

namespace App\Controller;


use App\Entity\Post;
use App\Entity\PostLike;
use Doctrine\ORM\EntityManager;
use App\Repository\PostRepository;

use App\Repository\PostLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     *@var PostRepository;
     */

    private $repository;
    private $em;
    private $post;

    public function __construct(PostRepository $repo, EntityManagerInterface $em, )
    {
        $this->repository = $repo; //Initialisation du repository
        $this->em = $em; //Initialisation du manager
    }

    #[Route('/', name: 'app_home')]
    public function index(PostRepository $repo, ): Response
    {
        $posts = $repo->findBy([], ['title' => 'asc']);
        return $this->render('home/home.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/passezalaction', name: 'app_passezalaction')]
    public function passezalaction(): Response
    {
        return $this->render('Pages/passezalaction.html.twig');
    }
}
