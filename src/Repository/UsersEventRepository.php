<?php

namespace App\Repository;

use App\Entity\UsersEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UsersEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersEvent[]    findAll()
 * @method UsersEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersEvent::class);
    }

    public function findAllRegisteredPlayerOfEvent($idEvent)
    {
        return $this->getEntityManager()->createQueryBuilder()
        ->select('u.Pseudo')
        ->from('App\Entity\UsersEvent', 'ue')
        ->leftJoin('ue.user', 'u')
        ->andWhere('ue.event = :val1')
        ->setParameter('val1', $idEvent)
        ->getQuery()
        ->getResult();
    }

    public function countRegisteredPlayerByEvent()
    {
        return $this->getEntityManager()->createQueryBuilder()
        ->select('e.id, count(ue.id) as nbPlayer')
        ->from('App\Entity\UsersEvent', 'ue')
        ->leftJoin('ue.user', 'u')
        ->leftJoin('ue.event', 'e')
        ->groupBy('ue.event')
        ->orderBy('e.created_at', 'desc')
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return UsersEvent[] Returns an array of UsersEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UsersEvent
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
