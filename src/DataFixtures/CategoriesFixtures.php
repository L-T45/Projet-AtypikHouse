<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $titles=[
            'Château hanté','Cabanes suspendues','Container','Palais','Grotte','Igloo','Maison de hobbit','Maisons bulles','Tipi'
        ];

        $slug=[
            'chateaux-hantees','cabanes-suspendues','container','palais','grotte','igloo','maison-de-hobbit','maisons-bulles','tipi'
        ];

        $n=1;

       // initialisation de l'objet Faker
       $faker = Faker\Factory::create('fr_FR');
       $categories = Array();
      // create 20 Categories! Bam!
      for ($i = 0; $i < 9; $i++) {
          $categories[$i] = new Categories();
          $categories[$i]->setTitle($titles[$i]);
          $categories[$i]->setSlug($slug[$i]);
          $categories[$i]->setPicture($i+$n.".webp");
          $categories[$i]->setDescription($faker->text);
          $manager->persist($categories[$i]);

          // On enregistre les catégories dans une référence 
          $this->addReference('categories_'. $i, $categories[$i]);
      }
    $manager->flush();
    }
}
