<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/article/{id}', name: 'app_article')]
    public function index($id, PostRepository $repo): Response
    {
        $article = $repo->find($id);
        if (!$article) {
            throw $this->createNotFoundException('L\'article demandé n\'existe pas');
        } 
        return $this->render('Pages/article.html.twig', [
            'article' => $article,
        ]);
    }
}

