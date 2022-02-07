<?php

namespace App\Repository;

use App\Entity\Equipements;
use App\Entity\Properties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;


/**
 * @method Equipements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipements[]    findAll()
 * @method Equipements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipements::class);
    }

    // /**
    //  * @return Equipements[] Returns an array of Equipements objects
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
    public function findOneBySomeField($value): ?Equipements
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

      /**
      * @return Equipements[] Returns an array of Equipements objects
      */

      public function findLatest():array
      {
          return $this->createQueryBuilder('e')
          ->orderBy('e.id', 'DESC')
          ->setMaxResults(10)
          ->getQuery()
          ->getResult();
      }

        /**
    * @return Equipements[] Returns an array of Equipements objects
    */
    public function findByIdToDelete($id, $lockMode = null, $lockVersion = null)
    {
        return $this->createQueryBuilder('u')
            ->delete()
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
      * @return Equipements[] Returns an array of Properties objects
      */

      public function findByEquipements(string $title):array
      {
          return $this->createQueryBuilder('e')
          ->select('e.id')
          ->andWhere('e.title = :title')
          ->setParameter('title', $title)
          ->getQuery()
          ->getResult();
      }


       
    /**
      * @return Equipements[] Returns an array of Properties objects
      */

    public function DeleteEquipementsByProperties($id)
    {
        return $this->createQueryBuilder('e')
            ->delete('e')
            ->leftJoin('e.properties','p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

}
