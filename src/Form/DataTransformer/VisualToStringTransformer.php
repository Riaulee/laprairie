<?php

namespace App\Form\DataTransformer;

use App\Entity\Visual;
use App\Repository\VisualRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class VisualToStringTransformer implements DataTransformerInterface
{
    private $visualRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->visualRepository = $entityManager->getRepository(Visual::class);
    }

    public function transform($visual): string
    {
        if (!$visual) {
            return '';
        }

        return $visual->getFileName();
    }

    public function reverseTransform($filename): ?Visual
    {
        if (!$filename) {
            return null;
        }

        $visual = $this->visualRepository->findOneBy(['fileName' => $filename]);

        if (!$visual) {
            throw new TransformationFailedException('Fichier introuvable');
        }

        return $visual;
    }
}
