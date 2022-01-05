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
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PropertiesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $properties = Array();
        // create 20 Properties! Bam!
        for ($i = 0; $i < 9; $i++) {

            $categories[$i] =  $this->getReference('categories_'. $faker->numberBetween(1,8));
            $properties_gallery[$i] =  $this->getReference('properties_gallery_'. $faker->numberBetween(1,8));
            $user[$i] =  $this->getReference('user_'. $i, $faker->numberBetween(1,8));

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
            $properties[$i]->setCategories($categories[$i]);
            $properties[$i]->setPropertiesgallery($properties_gallery[$i]);
            $properties[$i]->setUser($user[$i]);
            $manager->persist($properties[$i]);

             // On enregistre les propriétés dans une référence 
             $this->addReference('properties_'. $i, $properties[$i]);
        }

        $manager->flush();
        }

        public function getDependencies(){
            return [
                CategoriesFixtures::class,
                PropertiesGalleryFixtures::class,
                UserFixtures::class,
            ];
        }
}
