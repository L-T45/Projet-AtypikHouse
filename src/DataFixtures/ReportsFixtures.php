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
        for ($i = 1; $i < 40; $i++) {

            //$RandomObject = $faker->randomElement(1,3);

            $reports_categories[$i] =  $this->getReference('reports_categories_'. $faker->numberBetween(1,4));
           // $user[$i] =  $this->getReference('user_'.$faker->numberBetween(1,29));
           // $comments[$i] =  $this->getReference('comments_'.$faker->numberBetween(1,29));
           // $properties[$i] =  $this->getReference('properties_'.$faker->numberBetween(1,29));

            $reports[$i] = new Reports();
            $reports[$i]->setReportState($faker->randomElement($states));
            $reports[$i]->setDescription($faker->text(500));
            $reports[$i]->setReportscategories($reports_categories[$i]);

            $manager->persist($reports[$i]);

             // On enregistre les signalements dans une référence 
             $this->addReference('reports_'. $i, $reports[$i]);
        }

        $manager->flush();
        }

        public function getDependencies(){
            return [
                ReportsCategoriesFixtures::class,
               
                
            ];
        }
}