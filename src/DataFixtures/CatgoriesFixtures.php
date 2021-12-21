<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $categories = Array();
        // create 20 Categories! Bam!
        for ($i = 0; $i < 21; $i++) {
            $categories[$i] = new Categories();
            $categories[$i]->setTitle($faker->text);
            $categories[$i]->setPicture($faker->imageUrl($width = 640, $height = 480));
            $manager->persist($categories[$i]);
        }

        $manager->flush();
        }
}
