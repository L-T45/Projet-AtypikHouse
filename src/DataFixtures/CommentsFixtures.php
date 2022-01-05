<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Comments;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $comments = Array();
        // create 20 Comments! Bam!
        for ($i = 0; $i < 9; $i++) {

            $reservations[$i] =  $this->getReference('reservations_'. $faker->numberBetween(1,8));
            $user[$i] =  $this->getReference('user_'. $faker->numberBetween(1,8));

            $comments[$i] = new Comments();
            $comments[$i]->setBody($faker->text);
            $comments[$i]->setValue($faker->numberBetween($min = 1, $max = 5));
            $comments[$i]->setUsername($faker->firstName($gender = 'male'|'female'));
            $comments[$i]->setUserpicture($faker->imageUrl($width = 640, $height = 480));        
            $comments[$i]->setPropertypicture($faker->imageUrl($width = 640, $height = 480));
            $comments[$i]->setReservations($reservations[$i]);
            $comments[$i]->setUser($user[$i]);
            $manager->persist($comments[$i]);
        }

        $manager->flush();
        }

        public function getDependencies(){
            return [
                ReservationsFixtures::class,
                UserFixtures::class
            ];
        }
}