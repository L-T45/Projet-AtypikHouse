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

            $RandomObject = $faker->randomElement([1,2,3]);
            $startDate = $faker->dateTime($max = 'now'); 

            $reports_categories[$i] =  $this->getReference('reports_categories_'. $faker->numberBetween(1,7));
            $user[$i] =  $this->getReference('user_'.$faker->numberBetween(1,23));
            $comments[$i] =  $this->getReference('comments_'.$faker->numberBetween(1,150));
            $properties[$i] =  $this->getReference('properties_'.$faker->numberBetween(1,145));

            $reports[$i] = new Reports();
            $reports[$i]->setReportState($faker->randomElement($states));
            $reports[$i]->setDescription($faker->text(500));
            $reports[$i]->setReportscategories($reports_categories[$i]);
            $reports[$i]->setCreatedAt($faker->dateTimeBetween($startDate = '-20 days', $endDate = '-4 days'));

            if($RandomObject == 1)
            {
                $reports[$i]->setProperties(null);
                $reports[$i]->setComments($comments[$i]);
                $reports[$i]->setUser(null);
            }
           
            if($RandomObject == 2)
            {
                $reports[$i]->setProperties($properties[$i]);
                $reports[$i]->setComments(null);
                $reports[$i]->setUser(null);

            }

            if($RandomObject == 3)
            {
                $reports[$i]->setProperties(null);
                $reports[$i]->setComments(null);
                $reports[$i]->setUser($user[$i]);
            }
           

            $manager->persist($reports[$i]);

             // On enregistre les signalements dans une référence 
             $this->addReference('reports_'. $i, $reports[$i]);
        }

        $manager->flush();
        }

        public function getDependencies(){
            return [
                ReportsCategoriesFixtures::class,
                PropertiesFixtures::class,
                CommentsFixtures::class,
                UserFixtures::class,
               
                
            ];
        }
}