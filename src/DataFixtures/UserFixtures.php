<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $user = Array();
        // create 20 User! Bam!
        for ($i = 0; $i < 21; $i++) {
            $user[$i] = new User();
            $user[$i]->setEmail($faker->email);        
            $user[$i]->setRoles([]);     
            $user[$i]->setPassword($faker->password);
            $user[$i]->setLastname($faker->lastname);
            $user[$i]->setPhone($faker->numberBetween($min = 100000000, $max = 999999999));
            $user[$i]->setAddress($faker->address);
            $user[$i]->setCity($faker->city);
            $user[$i]->setBirthdate($faker->dateTime($max = 'now'));
            $user[$i]->setZipCode($faker->numberBetween($min = 10000, $max = 99999));
            $user[$i]->setEmailvalidated($faker->numberBetween($min = 0, $max = 1));
            $user[$i]->setFirstname($faker->firstName($gender = 'male'|'female'));
            $user[$i]->setCountry($faker->country);
            $user[$i]->setPicture($faker->imageUrl($width = 640, $height = 480));
            $user[$i]->setIsBlocked($faker->numberBetween($min = 0, $max = 1));
            $manager->persist($user[$i]);

            // On enregistre les catégories dans une référence 
            //$this->addReference('user_'. $i, $user[$i]);
        }

        $manager->flush();
        }
}
