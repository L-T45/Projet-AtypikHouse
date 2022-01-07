<?php

namespace App\Repository;

use App\Entity\Attributes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Attributes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attributes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attributes[]    findAll()
 * @method Attributes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attributes::class);
    }

    // /**
    //  * @return Attributes[] Returns an array of Attributes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Attributes
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
