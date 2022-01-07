<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Messages;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MessagesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $messages = Array();
        // create 20 Messages! Bam!
        for ($i = 0; $i < 9; $i++) {

            $conversations[$i] =  $this->getReference('conversations_'. $faker->numberBetween(1,8));
            $user[$i] =  $this->getReference('user_'. $faker->numberBetween(1,8));

            $messages[$i] = new Messages();
            $messages[$i]->setBody($faker->text);
            $messages[$i]->setConversations($conversations[$i]);
            $messages[$i]->setUser($user[$i]);
            $manager->persist($messages[$i]);
        }

        $manager->flush();
        }

        public function getDependencies(){
            return [
                ConversationsFixtures::class,
                UserFixtures::class,
            ];
        }
}