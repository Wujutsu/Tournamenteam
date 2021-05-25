<?php

namespace App\Repository;

use App\Entity\GamesEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GamesEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method GamesEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method GamesEvent[]    findAll()
 * @method GamesEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GamesEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GamesEvent::class);
    }

    // /**
    //  * @return GamesEvent[] Returns an array of GamesEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GamesEvent
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
