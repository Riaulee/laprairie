<?php

namespace App\Controller;

use Parsedown;
use App\Entity\Post;
use App\Entity\Visual;
use App\Entity\PostLike;
use App\Utils\FileUploader;
use App\Form\ArticleAddType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\VisualRepository;
use App\Repository\PostLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use \Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(PostRepository $repository, PaginatorInterface $paginator, Request $request, VisualRepository $vrepo, UserRepository $urepo): Response
    {
        $actualites = $paginator->paginate(
            $repository->findBy([], ['id' => 'desc']),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        $actualitesIds = [];
        $parsedown = new Parsedown();
        $actualitesIds = [];
        $htmlContent = [];

        foreach ($actualites as $actu) {
            $actualitesIds[] = $actu->getId();
            $htmlContent[] = $parsedown->text($actu->getContent());
        }

        return $this->render(
            'Pages/actualites.html.twig',
            [
                'actualites' => $actualites,
                'visual' => $vrepo->findBy(['idPost' => $actualitesIds], ['id' => 'DESC'],1),
                'content' => $htmlContent,
            ]
        );
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
    public function addArticle(
        Request $request,
        EntityManagerInterface $manager,
        Security $security,
        AuthorizationCheckerInterface $authChecker,
        FileUploader $fileUploader,
    ): Response {
        $user = $security->getUser();

        if (!$authChecker->isGranted('ROLE_EDITOR')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à ajouter un article.');
        }

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        if ($user) {
            $article = new Post();
            $form = $this->createForm(ArticleAddType::class, $article);
            $formView = $form->createView(); // Obtenir la vue du formulaire

            if ($request->isMethod('POST')) {
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $article->setIdUser($user);

                    $file = $form->get('visuals')->getData();

                    foreach ($file as $file) {
                        $visual = new Visual;
                        $visual->setIdPost($article);
                        $fileName = $fileUploader->upload($file);
                        $visual->setVisualName($fileName);
                        $article->addVisual($visual);
                    }

                    // Persister l'entité Article
                    $manager->persist($article);

                    //Tout enregistrer
                    $manager->flush();

                    $this->addFlash('success', 'L\'article a été ajouté avec succès.');
                    return $this->redirectToRoute('app_actualite');
                } else {
                    $this->addFlash('error', "Erreur de validation");;
                }
            }
        }

        return $this->render('Pages/addArticle.html.twig', [
            'form' => $formView,
        ]);
    }
}
