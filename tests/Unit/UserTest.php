<?php


namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Entity\Reservations;


class UserTest extends TestCase
{
   


    public function testGetEmail()
    {
        $user = new User();
      
        $this->user = $user;

        $value = 'test@atypikhouse.fr';
        $response = $this->user->setEmail($value);

        
        self::assertEquals($value, $this->user->getEmail());
        self::assertEquals($value, $this->user->getUsername());

    }

    public function testGetRoles()
    {
        $user = new User();
      
        $this->user = $user;

        $value = ['ROLE_USER','ROLE_OWNER','ROLE_ADMIN'];
        $response = $this->user->setRoles($value);

        
        self::assertEquals($value, $this->user->getRoles());

    }

    public function testGetPassword()
    {
        $user = new User();
      
        $this->user = $user;

        $value = 'password';
        $response = $this->user->setPassword($value);
        self::assertEquals($value, $this->user->getPassword());

    }

    public function testGetReservations()
    {
        $user = new User();
        $this->user = $user;
        
        $value = new Reservations();

        $response = $this->user->addReservation($value);

        self::assertTrue($this->user->getReservations()->contains($value));

    }


   





}