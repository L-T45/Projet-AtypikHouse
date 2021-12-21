<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Comments;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;

class CommentsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $comments = Array();
        // create 20 Comments! Bam!
        for ($i = 0; $i < 21; $i++) {
            $comments[$i] = new Comments();
            $comments[$i]->setBody($faker->text);
            $comments[$i]->setValue($faker->numberBetween($min = 1, $max = 5));
            $comments[$i]->setUsername($faker->firstName($gender = 'male'|'female'));
            $comments[$i]->setUserpicture($faker->imageUrl($width = 640, $height = 480));        
            $comments[$i]->setPropertypicture($faker->imageUrl($width = 640, $height = 480));
            $manager->persist($comments[$i]);
        }

        $manager->flush();
        }
}