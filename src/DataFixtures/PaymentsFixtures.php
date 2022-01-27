<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Payments;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PaymentsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $payments = Array();
        // create 20 Payments! Bam!
        for ($i = 0; $i < 101; $i++) {

            $user[$i] =  $this->getReference('user_'. $faker->numberBetween(1,23));

            $payments[$i] = new Payments();
            $payments[$i]->setAmount($faker->numberBetween($min = 1, $max = 9999));
            $payments[$i]->setIsPaidback($faker->numberBetween($min = 0, $max = 1));
            $payments[$i]->setPaidbackState($faker->text);
            $payments[$i]->setUser($user[$i]);
            $manager->persist($payments[$i]);

             // On enregistre les paiements dans une référence 
             $this->addReference('payments_'. $i, $payments[$i]);
        }

        $manager->flush();
        }

        public function getDependencies(){
            return [
                UserFixtures::class,
            ];                                                                                                                                                                                                                                    
        }
}