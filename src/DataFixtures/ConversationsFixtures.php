<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Conversations;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;

class ConversationsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $conversations = Array();
        // create 20 Equipements! Bam!
        for ($i = 1; $i < 50; $i++) {

            $startDate = $faker->dateTime($max = 'now'); 
           // $user[$i] =  $this->getReference('user_'.$faker->numberBetween(1,23));

            $conversations[$i] = new Conversations();
            $conversations[$i]->setCreatedAt($faker->dateTimeBetween($startDate = '-20 days', $endDate = '-4 days')); 
           // $conversations[$i]->addUser($user[$i]);
            $manager->persist($conversations[$i]);

              // On enregistre les conversations dans une référence 
              $this->addReference('conversations_'. $i, $conversations[$i]);
        }

        $manager->flush();
        }
        /*
        public function getDependencies(){
          return [

              UserFixtures::class
             
          ];
      }
      */

}