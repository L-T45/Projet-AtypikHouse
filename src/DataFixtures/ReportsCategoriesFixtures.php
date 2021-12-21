<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\ReportsCategories;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;

class ReportsCategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $reports_categories = Array();
        // create 20 Reports! Bam!
        for ($i = 0; $i < 21; $i++) {
            $reports_categories[$i] = new ReportsCategories();
            $reports_categories[$i]->setTitle($faker->text);
            $manager->persist($reports_categories[$i]);
        }

        $manager->flush();
        }
}