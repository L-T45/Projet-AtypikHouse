<?php

namespace App\Repository;

use App\Entity\Categories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Categories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categories[]    findAll()
 * @method Categories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categories::class);
    }

    // /**
    //  * @return Categories[] Returns an array of Categories objects
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
    * @return Categories|null
    */

    public function findPropertiesByCategory($id)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c,p.title')
            ->innerJoin('c.properties', 'p')
            ->where('c.id = :id')
            ->setParameter('id', $id);
        $query = $qb->getQuery();
        return $query->getResult();
    }
      
      
   
    public function findOneBySomeField($value): ?Categories
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
      * @return Properties[] Returns an array of Properties objects
      */

      public function findByCategories(string $title):array
      {
          return $this->createQueryBuilder('c')
          ->select('c.id')
          ->andWhere('c.title = :title')
          ->setParameter('title', $title)
          ->getQuery()
          ->getResult();
      }
    
      /**
    * @return Categories[] Returns an array of Categories objects
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
    * @return Categories[] Returns an array of Categories objects
    */
    public function modifier($id, $title, $lockMode = null, $lockVersion = null) {
        return $this->createQueryBuilder('c')
            ->update('App\Entity\Categories', 'c')
            ->set('c.title', ':title')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->setParameter('body', $title)
            ->getQuery()
            ->execute()
            ;                
    }
}
