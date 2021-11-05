<?php

namespace App\Repository;

use App\Entity\ReportsCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReportsCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportsCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportsCategories[]    findAll()
 * @method ReportsCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportsCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportsCategories::class);
    }

    // /**
    //  * @return ReportsCategories[] Returns an array of ReportsCategories objects
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

    /*
    public function findOneBySomeField($value): ?ReportsCategories
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
