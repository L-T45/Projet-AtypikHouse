<?php

namespace App\Repository;

use App\Entity\AttributesAnswers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AttributesAnswers|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttributesAnswers|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttributesAnswers[]    findAll()
 * @method AttributesAnswers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributesAnswersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttributesAnswers::class);
    }

    // /**
    //  * @return AttributesAnswers[] Returns an array of AttributesAnswers objects
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

    /**
     * @return AttributesAnswers[] Returns an array of AttributesAnswers objects
    */
    
    public function findAttributesAnswersByid($id)
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }


    

    /*
    public function findOneBySomeField($value): ?AttributesAnswers
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
