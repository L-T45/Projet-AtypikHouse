<?php

namespace App\Repository;

use App\Entity\Properties;
use App\Entity\Reservations;
use App\Entity\Categories;
use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Properties|null find($id, $lockMode = null, $lockVersion = null)
 * @method Properties|null findOneBy(array $criteria, array $orderBy = null)
 * @method Properties[]    findAll()
 * @method Properties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertiesRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, Properties::class);
    }

    // /**
    //  * @return Properties[] Returns an array of Properties objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @return Properties[] Returns an array of Properties objects
     */

    public function findLatest(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Properties[] Returns an array of Properties objects
     */

    public function findAddress(string $address): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id')
            ->andWhere('p.address = :address')
            ->setParameter('address', $address)
            ->getQuery()
            ->getResult();
    }


    public function findById(int $id)
    {
        $prop =  $this->createQueryBuilder('p')
            ->select('p.price')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        // dd($prop);
        // dd($prop[0]->price);

        return $prop[0]["price"];
    }



    /**
     * @return Properties[] Returns an array of Properties objects
     */

    public function theBestRatedProperty(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id,p.title,r.id,c.value')
            ->innerJoin('p.reservations', 'r')
            ->innerJoin('r.comments', 'c')
            ->getQuery()
            ->getResult();
    }

    public function findAllWithoutOldComite()
    {
        return $this->createQueryBuilder('fc')
            ->addSelect('f')
            ->leftJoin('fc.famille', 'f')
            ->andWhere('fc.actif = 1')
            ->leftJoin('fc.comite', 'c')
            ->orderBy('f.nomChefFoyer', 'ASC')
            ->getQuery()
            ->getResult();
    }



    public function findOneBySomeField($value): ?Properties
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Properties[] Returns an array of Properties objects
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
      * @return Properties[] Returns an array of Properties objects
      */

      public function FindByPropertiesUpdate($id):array
      {
          return $this->createQueryBuilder('p')
              ->select('u.email')
              ->innerJoin('p.user', 'u')
              ->innerJoin('p.categories', 'c')
              ->where('c.id = :id')
              ->setParameter('id', $id)
              ->groupBy('u.email')
              ->getQuery()
              ->getResult()
          ;
      }
    
    /**
      * @return Properties[] Returns an array of Properties objects
      */

      public function FindByPropertiesPost():array
      {
          return $this->createQueryBuilder('p')
              ->select('u.email')
              ->innerJoin('p.user', 'u')
              ->groupBy('u.email')
              ->getQuery()
              ->getResult()
          ;
      }

      /**
      * @return Properties[] Returns an array of Properties objects
      */

      public function FindByPropertiesDelete():array
      {
          return $this->createQueryBuilder('p')
              ->select('u.email')
              ->innerJoin('p.user', 'u')
              ->groupBy('u.email')
              ->getQuery()
              ->getResult()
          ;
      }

      /**
      * @return Properties[] Returns an array of Properties objects
      */

      public function FindByPropertiesDeleteAttributes():array
      {
          return $this->createQueryBuilder('p')
              ->select('u.email')
              ->innerJoin('p.user', 'u')
              ->groupBy('u.email')
              ->getQuery()
              ->getResult()
          ;
      }

      /**
      * @return Properties[] Returns an array of Properties objects
      */

      public function FindByPropertiesDeleteEquipements():array
      {
          return $this->createQueryBuilder('p')
              ->select('u.email')
              ->innerJoin('p.user', 'u')
              ->groupBy('u.email')
              ->getQuery()
              ->getResult()
          ;
      }

      /**
      * @return Properties[] Returns an array of Properties objects
      */

      public function FindByUserCreateProperties($idUser):array
      {
          //dd($idUser);
          return $this->createQueryBuilder('p')
              ->select('u.roles')
              ->innerJoin('p.user', 'u')
              ->where('p.user = :user')
              ->setParameter('user', $idUser)
              ->getQuery()
              ->getResult()
          ;
      }

      /**
      * @return Properties[] Returns an array of Properties objects
      */

      public function findByCategoriesUsedByProperties($idCategories):array
      {
          //dd($idUser);
          return $this->createQueryBuilder('p')
          ->select('p.id')
          ->innerJoin('p.categories', 'c')
          ->where('c.id = :id')
          ->setParameter('id', $idCategories)
          ->getQuery()
          ->getResult()
          ;
      }
      
}
