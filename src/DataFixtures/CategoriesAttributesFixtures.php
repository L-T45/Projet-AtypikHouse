<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\CategoriesAttributes;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategoriesAttributesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $categories_attributes = Array();
        // create 20 Categories! Bam!
        for ($i = 0; $i < 9; $i++) {
            
            $categories[$i] =  $this->getReference('categories_'. $faker->numberBetween(1,8));

            $categories_attributes[$i] = new CategoriesAttributes();
            $categories_attributes[$i]->setTitle($faker->text);
            $categories_attributes[$i]->setCategories($categories[$i]);
            $manager->persist($categories_attributes[$i]);
        }

        $manager->flush();
        }

        public function getDependencies(){
            return [
                CategoriesFixtures::class,
            ];
        }
}