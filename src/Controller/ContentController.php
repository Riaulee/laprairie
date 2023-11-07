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
        $content1 = $repo->findOneBy(['ponderation' => 1]);
        $content2 = $repo->findOneBy(['ponderation' => 2]);
        $content3 = $repo->findOneBy(['ponderation' => 3]);
        $content4 = $repo->findOneBy(['ponderation' => 4]);
        $content5 = $repo->findOneBy(['ponderation' => 5]);
        $content6 = $repo->findOneBy(['ponderation' => 6]);
        $content7 = $repo->findOneBy(['ponderation' => 7]);

        return $this->render('pages/quisommesnous.html.twig', [
            'content1' => $content1,
            'content2' => $content2,
            'content3' => $content3,
            'content4' => $content4,
            'content5' => $content5,
            'content6' => $content6,
            'content7' => $content7,
        ]);
    }
}
