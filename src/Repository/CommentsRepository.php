<?php

namespace App\Repository;

use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comments[]    findAll()
 * @method Comments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comments::class);
    }

     /**
      * @return Comments[] Returns an array of Comments objects
      */
    
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id,c.body,c.value,c.created_at,c.updated_at')
            ->andWhere('c.id = :id')
            ->setParameter('id', $id)
            //->orderBy('c.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

       /**
      * @return Comments[] Returns an array of Comments objects
      */

      public function findLatest():array
      {
          return $this->createQueryBuilder('c')
          ->orderBy('c.id', 'DESC')
          ->setMaxResults(10)
          ->getQuery()
          ->getResult();
      }
    

    /*
    public function findOneBySomeField($value): ?Comments
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
