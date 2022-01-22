<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\PropertiesGallery;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PropertiesGalleryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

       
         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $properties_gallery = Array();
        // create 20 PropertiesGallery! Bam!
        for ($i = 1; $i < 30; $i++) {

            $properties[$i] =  $this->getReference('properties_'. $faker->numberBetween(1,149));

            $properties_gallery[$i] = new PropertiesGallery();
            $properties_gallery[$i]->setPicture($faker->numberbetween(200,250).".webp");
            $properties_gallery[$i]->setAlt($faker->text);
            $properties_gallery[$i]->setProperties($properties[$i]);
            $manager->persist($properties_gallery[$i]);

             // On enregistre les galeries dans une référence 
             $this->addReference('properties_gallery_'. $i, $properties_gallery[$i]);
        }

        $manager->flush();
        }

        public function getDependencies(){
            return [
                PropertiesFixtures::class,

            ];
        }
}