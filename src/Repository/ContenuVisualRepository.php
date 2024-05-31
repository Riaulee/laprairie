<?php

namespace App\Repository;

use App\Entity\ContenuVisual;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContenuVisual>
 *
 * @method ContenuVisual|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContenuVisual|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContenuVisual[]    findAll()
 * @method ContenuVisual[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContenuVisualRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContenuVisual::class);
    }

//    /**
//     * @return ContenuVisual[] Returns an array of ContenuVisual objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ContenuVisual
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
