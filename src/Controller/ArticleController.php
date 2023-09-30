<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    private $repository;
    private $em;
    private $post;

    // $this->commentRepo = $commentRepo; //Initialisation du repository
    public function __construct(PostRepository $repo, EntityManagerInterface $em,)
    {
        $this->repository = $repo; //Initialisation du repository
        $this->em = $em; //Initialisation du manager
    }
    
    #[Route('/article/{id}', name: 'app_article')]
public function index($id, PostRepository $repo, EntityManagerInterface $em, Request $request, CommentRepository $crepo): Response
{
    $article = $repo->find($id);
    $comment = new Comment();

    $form = $this->createForm(CommentType::class, $comment);

    if (!$article) {
        throw $this->createNotFoundException('L\'article demandé n\'existe pas');
    }

    if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $comment->setPosts($article);
            $comment->setUsers($user);

            $em->persist($comment);
            $em->flush();
        }
    }

    return $this->render('Pages/article.html.twig', [
        'article' => $article,
        'comments' => $crepo->findBy(['posts' => $article], ['createdAt' => 'DESC']),
        'form' => $form->createView(),
    ]);
}
}

