<?php

namespace App\Repository;

use App\Entity\Conversations;
use App\Entity\Messages;
use App\Entity\User;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Conversations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conversations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conversations[]    findAll()
 * @method Conversations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conversations::class);
    }

    // /**
    //  * @return Conversations[] Returns an array of Conversations objects
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

     /**
      * @return Conversations[] Returns an array of Conversations objects
      */


    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return $this->createQueryBuilder('c')
            ->select('m.id,m.body,m.created_at,u.firstname,u.lastname,u.picture,c.created_at')
            ->innerJoin('c.messages','m')
            ->innerJoin('m.user','u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->orderBy('m.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    

    /*
    public function findOneBySomeField($value): ?Conversations
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
