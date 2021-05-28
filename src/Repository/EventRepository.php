<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findAllEventGame()
    {
        return $this->getEntityManager()->createQueryBuilder()
        ->select('e.id, e.title, e.observation, e.nb_player, g.name, g.name_img, u.Pseudo as creator')
        ->from('App\Entity\Event', 'e')
        ->leftJoin('e.game','g')
        ->leftJoin('e.user', 'u')
        ->orderBy('e.created_at', 'desc')
        ->getQuery()
        ->getResult();
    }

    public function findEventGame($idEvent)
    {
        return $this->getEntityManager()->createQueryBuilder()
        ->select('e.title, e.observation, e.nb_player, e.created_at, g.name, g.name_img')
        ->from('App\Entity\Event', 'e')
        ->leftJoin('e.game','g')
        ->andWhere('e.id = :val1')
        ->setParameter('val1', $idEvent)
        ->getQuery()
        ->getOneOrNullResult();
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
