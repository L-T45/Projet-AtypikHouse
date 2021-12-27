<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Reservations;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReservationsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
     
         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $reservations = Array();
        // create 20 Reservations! Bam!
        for ($i = 0; $i < 21; $i++) {

            //$payments[$i] =  $this->getReference('payments_'. $faker->numberBetween(1,20));
            $properties[$i] =  $this->getReference('properties_'. $faker->numberBetween(1,20));
            $user[$i] =  $this->getReference('user_'. $faker->numberBetween(1,20));

            $reservations[$i] = new Reservations();
            $reservations[$i]->setStartdate($faker->dateTime($max = 'now'));     
            $reservations[$i]->setEndDate($faker->dateTime($max = 'now'));
            $reservations[$i]->setIsApprouved($faker->numberBetween($min = 0, $max = 1));
            $reservations[$i]->setIsCancelled($faker->numberBetween($min = 0, $max = 1));
            $reservations[$i]->setIsPaid($faker->numberBetween($min = 0, $max = 1));
            $reservations[$i]->setParticipantsNbr($faker->randomDigitNotNull);
            //$reservations[$i]->setPayments($payments[$i]);
            $reservations[$i]->setProperties($properties[$i]);
            $reservations[$i]->setUser($user[$i]);
            $manager->persist($reservations[$i]);

              // On enregistre les réservations dans une référence 
              $this->addReference('reservations_'. $i, $reservations[$i]);
        }

        $manager->flush();
        }

        public function getDependencies(){
            return [
               
                PropertiesFixtures::class,
                UserFixtures::class,
                //PaymentsFixtures::class,
            ];
        }

      



}


