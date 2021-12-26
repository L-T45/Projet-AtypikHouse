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

class PropertiesGalleryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $properties_gallery = Array();
        // create 20 PropertiesGallery! Bam!
        for ($i = 0; $i < 21; $i++) {
            $properties_gallery[$i] = new PropertiesGallery();
            $properties_gallery[$i]->setPicture($faker->imageUrl($width = 640, $height = 480));
            $properties_gallery[$i]->setAlt($faker->text);
            $manager->persist($properties_gallery[$i]);

             // On enregistre les galeries dans une référence 
             $this->addReference('properties_gallery_'. $i, $properties_gallery[$i]);
        }

        $manager->flush();
        }
}