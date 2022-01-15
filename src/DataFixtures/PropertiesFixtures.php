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

       // $n=1;

       
       $titles=['maison', 'cabane', 'palais', 'maisonnette'];

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $properties = Array();
        // create 20 Properties! Bam!
        for ($i = 1; $i < 150; $i++) {

            $categories[$i] =  $this->getReference('categories_'. $faker->numberBetween(1,8));
            $properties_gallery[$i] =  $this->getReference('properties_gallery_'. $faker->numberBetween(1,499));
            $user[$i] =  $this->getReference('user_'.$faker->numberBetween(1,29));

            $properties[$i] = new Properties();
            $properties[$i]->setTitle($faker->randomElement($titles));
            $properties[$i]->setSlug($faker->text);
            $properties[$i]->setPrice($faker->numberBetween($min = 20, $max = 200));
            $properties[$i]->setRooms($faker->randomDigitNotNull);
            $properties[$i]->setAddress($faker->streetAddress);
            $properties[$i]->setBooking($faker->randomDigitNotNull);
            $properties[$i]->setCity($faker->city);
            $properties[$i]->setLatitude($faker->randomFloat($nbMaxDecimals = 8, $min= 48.212, $max = 48.089));
            $properties[$i]->setLongitude($faker->randomFloat($nbMaxDecimals = 8, $min = 3.91, $max = 4.158));
            $properties[$i]->setBedrooms($faker->randomDigitNotNull);
            $properties[$i]->setSurface($faker->numberBetween($min = 1, $max = 853));
            $properties[$i]->setReference('Categories '.$i);
            $properties[$i]->setPicture($i.".webp");
            $properties[$i]->setCountry($faker->country);
            $properties[$i]->setCapacity($faker->randomDigitNotNull);
            $properties[$i]->setZipCode(intval($faker->postcode));
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
