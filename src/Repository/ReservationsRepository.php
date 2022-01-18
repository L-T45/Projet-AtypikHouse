<?php

namespace App\Repository;

use App\Entity\Reservations;
use App\Entity\Properties;
use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Reservations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservations[]    findAll()
 * @method Reservations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservations::class);
    }

    // /**
    //  * @return Reservations[] Returns an array of Reservations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
      * @return Reservations[] Returns an array of Reservations objects
      */

      public function findLatest():array
      {
          return $this->createQueryBuilder('r')
          ->orderBy('r.id', 'DESC')
          ->setMaxResults(10)
          ->getQuery()
          ->getResult();
      }

      /**
      * @return Reservations[] Returns an array of Reservations objects
      */

      public function theBestRatedProperty():array
      {
          return $this->createQueryBuilder('SELECT r,p.title FROM r JOIN r.properties p JOIN r.comments c WHERE avg(c.value) < ?3')
              //->select('p.title,avg(c.value) as value_avg')
              //->innerJoin('r.properties', 'p')
             // ->innerJoin('r.comments', 'c')
             // ->groupBy('p.title')
             ->getQuery()
             ->getResult();
    
            
          
      }


    /*
    public function findOneBySomeField($value): ?Reservations
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
