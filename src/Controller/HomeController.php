<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\PostLike;
use App\Repository\EventRepository;
use App\Repository\PostLikeRepository;
use Doctrine\ORM\EntityManager;

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
    private $event;

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
     * @param \App\Entity\Event $event
     * @param EntityManagerinterface $em
     * @param PostLikeRepository $repoLike
     * @return Response
     * 
     * @var EventRepository;
     * 
     */
    
    #[Route('/post/{id}/like', name: 'app_like')]
    public function like(Event $event, EntityManagerinterface $em, PostLikeRepository $likeRepo) : 
    Response{

        $user = $this->getUser();

        if(!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);

        if($event->isLikedByUser($user)){
            $like = $likeRepo->findOneBy([
                'event' => $event,
                'user' => $user
            ]);

            $em->remove($like);
            $em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $likeRepo->count(['event' => $event])
            ],200);
        }

        $like = new PostLike();
        $like->setEvent($event)
            ->setUser($user);

        $em->persist($like);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like bien ajouté',
            'likes'=> $likeRepo->count(['event'=>$event])
        ], 200);

        return $this->json(['code' => 200, 'message'=>'Ca marche bien'], 200);
    }
}
