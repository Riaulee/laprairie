<?php

namespace App\Controller;

use App\Repository\ContenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentController extends AbstractController
{
    #[Route('/quisommesnous', name: 'app_quisommesnous')]
    public function index(ContenuRepository $repo,): Response
    {
        $contentimpair = $repo->createQueryBuilder('c')
        ->where('MOD(c.ponderation, 2) = 1')
        ->orderBy('c.ponderation', 'ASC')
        ->getQuery()
        ->getResult();

    $contentpair = $repo->createQueryBuilder('c')
        ->where('MOD(c.ponderation, 2) = 0')
        ->orderBy('c.ponderation', 'ASC')
        ->getQuery()
        ->getResult();
        
        return $this->render('Pages/quisommesnous.html.twig', [
            'contentimpair' => '$contentimpair',
            'contentpair' => '$contentpair'
        ]);
    }
}
