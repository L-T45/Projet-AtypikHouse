<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Attributes;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AttributesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {


        $attributes = ['Parking', 'barbecue', 'Animals', 'Transports', 'Wifi', 'Cuisine', 'Mini-bar'];

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $attributes = Array();
        // create 20 Categories! Bam!
        for ($i = 0; $i < 9; $i++) {
            
            $categories[$i] =  $this->getReference('categories_'. $faker->numberBetween(1,8));

            $attributes[$i] = new Attributes();
            $attributes[$i]->setTitle($attributes[$i]);
            $attributes[$i]->setCategories($categories[$i]);
            $manager->persist($attributes[$i]);
        }

        $manager->flush();
        }

        public function getDependencies(){
            return [
                CategoriesFixtures::class,
            ];
        }
}