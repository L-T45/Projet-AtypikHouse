<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\ReportsCategories;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;

class ReportsCategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $reportscategories=['arnaque', 'contenu à caractère pornographique', 'insulte', 'propos racistes', 'propos homophobes', 'contenu inapproprié'];
         // initialisation de l'objet Faker
         $faker = Faker\Factory::create('fr_FR');
         $reports_categories = Array();
        // create 20 Reports! Bam!
        for ($i = 0; $i < 6; $i++) {
            $reports_categories[$i] = new ReportsCategories();
            $reports_categories[$i]->setTitle($reportscategories[$i]);
            $manager->persist($reports_categories[$i]);

            // On enregistre les catégories de signalements dans une référence 
            $this->addReference('reports_categories_'. $i, $reports_categories[$i]);
        }

        $manager->flush();
        }
}