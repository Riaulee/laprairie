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

    public function __construct(PostRepository $repo, EntityManagerInterface $em)
    {
        $this->repository = $repo; //Initialisation du repository
        $this->em = $em; //Initialisation du manager
    }

    #[Route('/', name: 'app_home')]
    public function index(PostRepository $repo): Response
    {
        $posts = $repo->findBy([], ['title' => 'asc']);
        return $this->render('home/home.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * Permet de "liker" ou "unliker" un évènement
     * 
     * @param App\Entity\Post $posts
     * @param ObjectManager $manager
     * @param PostLikeRepository $repoLike
     * @return Response
     * 
     * @var PostRepository;
     * 
     */
    
    #[Route('/post/{id}/like', name: 'app_like')]
    public function like($id, EntityManagerinterface $em, PostLikeRepository $likeRepo) : 
    Response{

        $user = $this->getUser();

        if(!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);

        $post = $em->getRepository(Post::class)->find($id);

        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        if($post->isLikedByUser($user)){
            $like = $likeRepo->findOneBy([
                'post' => $post,
                'user' => $user
            ]);

            $em->remove($like);
            $em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $likeRepo->count(['post' => $post])
            ],200);
        }

        $like = new PostLike();
        $like->setPost($post)
            ->setUser($user);

        $em->persist($like);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like bien ajouté',
            'likes'=> $likeRepo->count(['post'=>$post])
        ], 200);

        return $this->json(['code' => 200, 'message'=>'Ca marche bien'], 200);
    }
}
