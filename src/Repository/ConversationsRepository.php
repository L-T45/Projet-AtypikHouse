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
            ->leftJoin('c.messages', 'm')
            ->leftJoin('m.user', 'u')
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    /**
     * @return Conversations[] Returns an array of Conversations objects
     */

    public function findLatest(): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c.id as conversations_id,MAX(m.created_at) AS max_messages, m.id as messages_id, m.body, m.created_at, u.id as user_id, u.lastname, u.firstname, u.picture')
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

    public function findMessagesDetails($id): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('m.id, m.body, m.created_at')
            ->leftJoin('c.messages', 'm', 'WITH', 'c.id = m.conversations_id')
            ->leftJoin('m.user', 'u')
            ->orderBy('m.id', 'DESC')
            ->setParameter('id', $id);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @return Conversations[] Returns an array of User objects
     */

    public function findConversationsByUser($id)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c.id as conversations_id,c.created_at as conversations_created_at, m.id as messages_id, m.body,u.id as user_id,u.firstname,u.lastname,u.picture')
            ->leftJoin('c.users', 'u')
            ->leftJoin('c.messages', 'm')
            ->where('u.id = :id')
            ->setParameter('id', $id);
        // ->groupBy('c.id');
        //  ->orderBy('c.created_at', 'DESC');
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

    /**
     * @return Conversations[] Returns an array of Conversations objects
     */
    public function findByIdToDelete($id, $lockMode = null, $lockVersion = null)
    {
        return $this->createQueryBuilder('u')
            ->delete()
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Conversations Returns an array of Conversations objects
     */
    public function checkIfExist($id1, $id2)
    {

        $query = $this->createQueryBuilder('c');
        $query->select('c.id, u.id as user_id')
            ->leftJoin('c.users', 'u')
            ->where('u.id = :id1 OR u.id = :id2')
            // ->andWhere('u.id = :id2')
            ->setParameter('id1', $id1)
            ->setParameter('id2', $id2);

        $query = $query->getQuery();
        return $query->getResult();
    }


    /**
     * @return Conversations Returns an array of Conversations objects
     */
    public function findConvIdByUser($id)
    {

        $query = $this->createQueryBuilder('c');
        $query->select('c.id')
            ->leftJoin('c.users', 'u')
            ->where('u.id = :id1')
            ->setParameter('id1', $id);

        $query = $query->getQuery();
        return $query->getResult();
    }
    /**
     * @return Conversations Returns an array of Conversations objects
     */
    public function findConvsByUser($ids)
    {


        //  $ids = [50, 2]; // Array of your values


        $query = $this->createQueryBuilder('c');
        $query->select('c.id, c.created_at, u.id as user_id,u.firstname, u.lastname, u.picture')
            ->leftJoin('c.users', 'u')
            ->add('where', $query->expr()->in('c.id', $ids));

        $query = $query->getQuery();
        return $query->getResult();
    }
}
