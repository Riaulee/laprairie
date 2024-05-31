<?php

namespace App\Controller;

use App\Repository\ContenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentController extends AbstractController
{
    #[Route('/quisommesnous', name: 'app_quisommesnous')]
    public function index(ContenuRepository $repo): Response
    {
        $content = $repo->findBy([], ['ponderation' => 'asc']);
        return $this->render('pages/quisommesnous.html.twig', [
            'content' => $content,
        ]);
    }
}