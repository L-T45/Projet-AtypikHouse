<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Reports;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReportsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $states=['accepté', 'rejeté', 'en attente'];

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $reports = Array();
        // create 20 Reports! Bam!
        for ($i = 0; $i < 9; $i++) {

            $reports_categories[$i] =  $this->getReference('reports_categories_'. $faker->numberBetween(1,4));
            $user[$i] =  $this->getReference('user_'. $faker->numberBetween(1,8));

            $reports[$i] = new Reports();
            $reports[$i]->setReportState($faker->randomElement($states));
            $reports[$i]->setDescription($faker->text(500));
            $reports[$i]->setReportscategories($reports_categories[$i]);
            $reports[$i]->setUser($user[$i]);
            $manager->persist($reports[$i]);
        }

        $manager->flush();
        }

        public function getDependencies(){
            return [
                ReportsCategoriesFixtures::class,
                UserFixtures::class,
            ];
        }
}