<?php

namespace App\Repository;

use App\Entity\Convertation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Convertation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Convertation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Convertation[]    findAll()
 * @method Convertation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConvertationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Convertation::class);
    }

    // /**
    //  * @return Convertation[] Returns an array of Convertation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Convertation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
