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

        // Liste des catégories à ajouter
$tab = array(
    array('title' => 'Château hanté', 'slug' => 'chateaux-hantees', 'picture' => 'p1', 'description' => 'd1'),
    array('title' => 'Cabanes suspendues', 'slug' => 'cabanes-suspendues', 'picture' => 'p2', 'description' => 'd2'),
    array('title' => 'Container', 'slug' => 'container', 'picture' => 'p3', 'description' => 'd3'),
    array('title' => 'Palais', 'slug' => 'palais', 'picture' => 'p4', 'description' => 'd4'),
    array('title' => 'Grotte', 'slug' => 'grotte', 'picture' => 'p5', 'description' => 'd5'),
    array('title' => 'Igloo', 'slug' => 'igloo', 'picture' => 'p6', 'description' => 'd6'),
    array('title' => 'Maison de hobbit', 'slug' => 'hobbit', 'picture' => 'p7', 'description' => 'd7'),
    array('title' => 'Maisons bulles', 'slug' => 'maisons-bulles', 'picture' => 'p8', 'description' => 'd8'),
    array('title' => 'Tipi', 'slug' => 'tipi', 'picture' => 'p9', 'description' => 'd9'),
);
        // create 9 Categories! Bam!
        foreach ($tab as $categories) {

            $categorie = new Categories();

            $categorie->setTitle($categories['title']);
            $categorie->setSlug($categories['slug']);
            $categorie->setPicture($categories['picture']);
            $categorie->setDescription($categories['description']);
            $manager->persist($categorie);

            // On enregistre les catégories dans une référence 
            //$this->addReference('categories_'. $i, $categories[$i]);
        }

        $manager->flush();
        }
}
