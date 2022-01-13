<?php

namespace App\Repository;

use App\Entity\Conversations;
use App\Entity\Messages;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

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

    /*
        SELECT
 
            c,
        
            m.id
        
        FROM
        
        c
        
            LEFT JOIN m
    
                ON c.id = m.conversations_id
                    
        ORDER BY m.id DESC
    */

    public function findLatest():array
    {
        $qb = $this->createQueryBuilder('c');
        $qb ->select('m.id, m.body, m.created_at, u.id, u.lastname, u.firstname, u.picture, c.id')
            ->leftJoin('c.messages', 'm')
            ->leftJoin('m.user', 'u')
            ->orderBy('m.id', 'DESC');
            // ->setMaxResults(1);
        $query = $qb->getQuery();
        return $query->getResult();
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
