<?php

namespace App\Repository;

use App\Entity\PropertiesGallery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PropertiesGallery|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertiesGallery|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertiesGallery[]    findAll()
 * @method PropertiesGallery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertiesGalleryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertiesGallery::class);
    }

    // /**
    //  * @return PropertiesGallery[] Returns an array of PropertiesGallery objects
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

    /*
    public function findOneBySomeField($value): ?PropertiesGallery
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
      * @return Properties[] Returns an array of Properties objects
      */

      public function findByPropertiesGallery($properties):array
      {
          return $this->createQueryBuilder('pg')
          ->select('pg.id')
          ->andWhere('pg.alt = :alt')
          ->setParameter('alt', $alt)
          ->getQuery()
          ->getResult();
      }

       /**
    * @return PropertiesGallery[] Returns an array of PropertiesGallery objects
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
      * @return PropertiesGallery[] Returns an array of Properties objects
      */

      public function findByProperties($idPropertiesGallery, $lockMode = null, $lockVersion = null)
      {
        return $this->createQueryBuilder('pg')
            ->select('p.id')
            ->innerJoin('pg.properties', 'p')
            ->where('pg.id = :id')
            ->setParameter('id', $idPropertiesGallery)
            ->getQuery()
            ->getResult()
        ;
      }
}
