<?php

namespace App\Repository;

use App\Entity\Messages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Messages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Messages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Messages[]    findAll()
 * @method Messages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Messages::class);
    }


    /**
     * @return Conversations[] Returns an array of Conversations objects
     */

    public function findConversationsByid($id, $lockMode = null, $lockVersion = null)
    {
        $qb = $this->createQueryBuilder('m');
        $qb->select('m.id as messages_id,m.body,u.id as user_id,u.firstname,u.lastname,u.picture, m.created_at')
            ->leftJoin('m.conversations', 'c')
            ->leftJoin('m.user', 'u')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->orderBy('m.created_at', 'DESC');

        $query = $qb->getQuery();
        return $query->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Messages
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Messages[] Returns an array of Messages objects
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
}
