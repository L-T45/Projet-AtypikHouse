<?php

namespace App\Repository;

use App\Entity\CategoriesAttributes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoriesAttributes|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriesAttributes|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriesAttributes[]    findAll()
 * @method CategoriesAttributes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesAttributesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriesAttributes::class);
    }

    // /**
    //  * @return CategoriesAttributes[] Returns an array of CategoriesAttributes objects
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

    /*
    public function findOneBySomeField($value): ?CategoriesAttributes
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
