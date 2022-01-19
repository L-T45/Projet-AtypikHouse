<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Messages;
use App\Entity\Conversations;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
      * @return User[] Returns an array of User objects
    */
   
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return $this->createQueryBuilder('u')
            ->select('m.id,m.body,m.created_at,u.firstname,u.lastname,u.picture,c.id')
            ->innerJoin('u.messages','m')
            ->innerJoin('m.conversations','c')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->orderBy('m.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

     /**
      * @return User[] Returns an array of User objects
    */
   
    public function findConversationsidByUser($id, $lockMode = null, $lockVersion = null)
    {
        return $this->createQueryBuilder('u')
            ->select('m.id,m.body,m.created_at,u.firstname,u.lastname,u.picture,c.id,c.created_at')
            ->innerJoin('u.messages','m')
            ->innerJoin('m.conversations','c')
           // ->innerJoin('c.users','u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
          //  ->orderBy('m.id', 'DESC')
           // ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
