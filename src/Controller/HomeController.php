<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\PostLikeRepository;
use Doctrine\Persistence\ObjectManager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     *@var EventRepository;
     */

    private $repository;
    private $em;

    public function __construct(EventRepository $repo, EntityManagerInterface $em)
    {
        $this->repository = $repo; //Initialisation du repository
        $this->em = $em; //Initialisation du manager
    }

    #[Route('/', name: 'app_home')]
    public function index(EventRepository $repo): Response
    {
        $events = $repo->findBy([], ['title' => 'asc']);
        return $this->render('home/home.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * Permet de "liker" ou "unliker" un évènement
     * 
     * @param Event $events
     * @param ObjectManager $manager
     * @param PostLikeRepository $repoLike
     * @return Response
     */
    
    #[Route('/post/{id}/like', name: 'app_like')]
    public function like() : 
    Response{
        return $this->json(['code' => 200, 'message'=>'Ca marche bien'], 200);
    }
// Event $events, ObjectManager $manager, PostLikeRepository $repoLike

}
