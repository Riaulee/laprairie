<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Visual;
use App\Entity\PostLike;
use App\Form\ArticleAddType;
use App\Repository\PostRepository;
use App\Repository\PostLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

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
        $actualites = $paginator->paginate(
            $repository->findBy([], ['id' => 'desc']),
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

    /**
     * Fonction permettant d'afficher le formulaire d'ajout d'article
     *
     * @return Response
     */
    #[Route('/addArticle', name: 'app_addarticle')]
    public function addArticle(Request $request, EntityManagerInterface $manager, Security $security, AuthorizationCheckerInterface $authChecker): Response
{
    $user = $security->getUser();
    
    if (!$authChecker->isGranted('ROLE_EDITOR')) {
        throw new AccessDeniedException('Vous n\'êtes pas autorisé à ajouter un article.');
    }

    if (!$user) {
        $this->addFlash('error', 'Vous devez être connecté pour ajouter un article.');
        return $this->redirectToRoute('app_login');
    }

    if ($user) {
    $article = new Post();
    $form = $this->createForm(ArticleAddType::class, $article);
    $formView = $form->createView(); // Obtenir la vue du formulaire
    $visual = new Visual();

    $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $listeimage = $form->get('visuals')->getData();
            $article = $form->getData();
            $article->setIdUser($user);
            // dd($article);
            if($listeimage){
                foreach ($article->getVisuals() as $visual) {
                    $visual->setArticle($article);
                    $manager->persist($visual);
                }
            }

            $manager->persist($article);
            $manager->flush();

            $this->addFlash('success', 'L\'article a été ajouté avec succès.');
            return $this->redirectToRoute('app_actualite');

        }
    }else{

    }

    return $this->render('Pages/addArticle.html.twig', [
        'form' => $formView, 
    ]);
    }

}
