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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    * @return User[] Returns an array of User objects
    */

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
    
    public function findByEmail(string $username): array
    {
        return $this->createQueryBuilder('u')
            ->select('u.id, u.email, u.roles, u.lastname, u.phone, u.address, u.city, u.birthdate, u.zipCode, u.created_at, u.updated_at, u.emailvalidated, u.firstname, u.country ,u.picture, u.is_blocked')
            ->andWhere('u.email = :email')
            ->setParameter('email', $username)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return User[] Returns an array of User objects
    */

    public function resetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $old_pwd = $request->get('old_password'); 
        $new_pwd = $request->get('new_password');
        $new_pwd_confirm = $request->get('new_password_confirm');

        $user = $this->getUser();
        $checkPass = $passwordEncoder->isPasswordValid($user, $old_pwd);

        if($checkPass === true) {    
                            
        } else {
            return new jsonresponse(array('error' => 'The current password is incorrect.'));
        }
    }
    
    public function findByEmailCheckIfExist(string $email): array
    {
        return $this->createQueryBuilder('u')
            ->select('u.email')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getResult()
        ;
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
