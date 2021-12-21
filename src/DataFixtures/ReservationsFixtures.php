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

class ReservationsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $reservations = Array();
        // create 20 Reservations! Bam!
        for ($i = 0; $i < 21; $i++) {
            $reservations[$i] = new Reservations();
            $reservations[$i]->setStartdate($faker->dateTime($max = 'now'));     
            $reservations[$i]->setEndDate($faker->dateTime($max = 'now'));
            $reservations[$i]->setIsApprouved($faker->numberBetween($min = 0, $max = 1));
            $reservations[$i]->setIsCancelled($faker->numberBetween($min = 0, $max = 1));
            $reservations[$i]->setIsPaid($faker->numberBetween($min = 0, $max = 1));
            $reservations[$i]->setParticipantsNbr($faker->randomDigitNotNull);
            $manager->persist($reservations[$i]);
        }

        $manager->flush();
        }
}
