<?php

namespace App\Repository;

use App\Entity\User;
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
            ->select('u.id')
            ->andWhere('u.email = :email')
            ->setParameter('email', $username)
            //->orderBy('u.id', 'ASC')
            //->setMaxResults(1)
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
