<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findAllFriendOfUser($idUser)
    {
        return $this->getEntityManager()->createQueryBuilder()
        ->select('c.id as idChat, u.id, u.Pseudo, c.accept')
        ->from('App\Entity\Contact', 'c')
        ->leftJoin('c.contact','u')
        ->andWhere('c.user = :val1')
        ->setParameter('val1', $idUser)
        ->orderBy('u.Pseudo', 'asc')
        ->getQuery()
        ->getResult();
    }

    public function findAllUserOfFriend($idUser)
    {
        return $this->getEntityManager()->createQueryBuilder()
        ->select('c.id as idChat, u.id, u.Pseudo, c.accept')
        ->from('App\Entity\Contact', 'c')
        ->leftJoin('c.user','u')
        ->andWhere('c.contact = :val1')
        ->setParameter('val1', $idUser)
        ->orderBy('u.Pseudo', 'asc')
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return Contact[] Returns an array of Contact objects
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
    public function findOneBySomeField($value): ?Contact
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
