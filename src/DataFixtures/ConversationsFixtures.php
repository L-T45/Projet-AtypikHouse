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
        for ($i = 0; $i < 9; $i++) {
            $conversations[$i] = new Conversations();
            $manager->persist($conversations[$i]);

              // On enregistre les conversations dans une référence 
              $this->addReference('conversations_'. $i, $conversations[$i]);
        }

        $manager->flush();
        }
}