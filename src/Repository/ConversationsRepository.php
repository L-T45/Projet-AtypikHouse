<?php

namespace App\Repository;

use App\Entity\Conversations;
use App\Entity\Messages;
use App\Entity\User;
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


      public function findAll()
      {
          return $this->createQueryBuilder('c')
              ->select('m.id,m.body,m.created_at,u.firstname,u.lastname,u.picture,c.id')
              ->leftJoin('c.messages','m')
              ->leftJoin('m.user','u')
              ->orderBy('m.id', 'DESC')
              ->getQuery()
              ->getResult()
          ;
      }
    /**
    * @return Conversations[] Returns an array of Conversations objects
    */

    public function findLatest():array
    {
        $qb = $this->createQueryBuilder('c');
        $qb ->select('c.id as conversations_id,MAX(m.created_at) AS max_messages, m.id as messages_id, m.body, m.created_at, u.id as user_id, u.lastname, u.firstname, u.picture')
            ->leftJoin('c.messages', 'm')
            ->leftJoin('m.user', 'u')
            ->orderBy('m.created_at', 'DESC')
            ->groupBy('c.id');
        $query = $qb->getQuery();
        return $query->getResult();
    }


    /**
    * @return Conversations[] Returns an array of Conversations objects
    */

    public function findMessagesDetails($id):array
    {
        $qb = $this->createQueryBuilder('c');
        $qb ->select('m.id, m.body, m.created_at')
            ->leftJoin('c.messages', 'm', 'WITH', 'c.id = m.conversations_id')
            ->leftJoin('m.user', 'u')
            ->orderBy('m.id', 'DESC')
            ->setParameter('id', $id);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    
    /**
    * @return Conversations[] Returns an array of Conversations objects
    */

    public function findConversationsByid($id, $lockMode = null, $lockVersion = null)
    {
        $qb = $this->createQueryBuilder('c');
        $qb ->select('c.id as conversations_id,c.created_at as conversations_created_at,MAX(m.created_at) AS max_messages,m.id as messages_id,m.body,u.id as user_id,u.firstname,u.lastname,u.picture')
            ->leftJoin('c.messages', 'm')
            ->leftJoin('m.user', 'u')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->orderBy('m.created_at', 'DESC')
            ->groupBy('m.id');
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
