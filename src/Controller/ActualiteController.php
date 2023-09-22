<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostLike;
use App\Repository\PostRepository;
use App\Repository\PostLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActualiteController extends AbstractController
{
    /**
     * Ce controller va chercher tous les articles et gère la pagination
     *
     * @param PostRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/actualite', name: 'app_actualite')]
    public function index(PostRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        // $actualites = $repository->findBy([], ['title' => 'asc']);

        $actualites = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('Pages/actualites.html.twig',
            ['actualites' => $actualites]);
    }

    #[Route('/post/{id}/like', name: 'app_like')]
    public function like($id, EntityManagerinterface $em, PostLikeRepository $likeRepo): Response
    {

        $user = $this->getUser();

        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);

        $post = $em->getRepository(Post::class)->find($id);

        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        if ($post->isLikedByUser($user)) {
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
            ], 200);
        }

        $like = new PostLike();
        $like->setPost($post)
            ->setUser($user);

        $em->persist($like);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like bien ajouté',
            'likes' => $likeRepo->count(['post' => $post])
        ], 200);

        return $this->json(['code' => 200, 'message' => 'Ca marche bien'], 200);
    }

    #[Route('/addArticle', name: 'app_addarticle')]
    public function addArticle(): Response
    {
        $article = new Post();

        return $this->render('Modal/articlemodal.html.twig');
    }

}
