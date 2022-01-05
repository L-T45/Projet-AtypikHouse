<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Equipements;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;

class EquipementsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $equipements = Array();
        // create 20 Equipements! Bam!
        for ($i = 0; $i < 9; $i++) {
            $equipements[$i] = new Equipements();
            $equipements[$i]->setTitle($faker->text);;
            $manager->persist($equipements[$i]);
        }

        $manager->flush();
        }
}