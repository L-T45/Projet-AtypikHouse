<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Properties;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;

class PropertiesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $properties = Array();
        // create 20 Properties! Bam!
        for ($i = 0; $i < 21; $i++) {
            $properties[$i] = new Properties();
            $properties[$i]->setTitle($faker->text);
            $properties[$i]->setSlug($faker->text);
            $properties[$i]->setPrice($faker->numberBetween($min = 20, $max = 200));
            $properties[$i]->setRooms($faker->randomDigitNotNull);
            $properties[$i]->setAddress($faker->address);
            $properties[$i]->setBooking($faker->randomDigitNotNull);
            $properties[$i]->setCity($faker->city);
            $properties[$i]->setLat($faker->latitude($min = -90, $max = 90));
            $properties[$i]->setLongitude($faker->longitude($min = -180, $max = 180));
            $properties[$i]->setBedrooms($faker->randomDigitNotNull);
            $properties[$i]->setSurface($faker->randomFloat);
            $properties[$i]->setReference('Categories '.$i);
            $properties[$i]->setPicture($faker->imageUrl($width = 640, $height = 480));
            $properties[$i]->setCountry($faker->country);
            $properties[$i]->setCapacity($faker->randomDigitNotNull);
            $properties[$i]->setZipCode($faker->numberBetween($min = 10000, $max = 99999));
            $manager->persist($properties[$i]);
        }

        $manager->flush();
        }
}
