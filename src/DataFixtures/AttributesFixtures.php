<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Attributes;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AttributesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $titles = ['Proche de la mer', 'Enfants de quel age ?', 'Convient aux personnes âgées', 'Détails', 'Silencieux', 'Au contact de la nature', 'A combien de mètre du sol', "Sec ou humide ?", "Combien de gardiens ?", "Aux normes", "Description du payasage"];
        $types = ["boolean", "number", "boolean", "string", "boolean", "boolean", "number", "string", "number", "boolean", "string"];

        // initialisation de l'objet Faker
        $faker = Faker\Factory::create('fr_FR');
        $attributes = array();
        // create 20 Categories! Bam!
        for ($i = 0; $i < 10; $i++) {

            $categories[$i] =  $this->getReference('categories_' . $faker->numberBetween(1, 9));

            $attributes[$i] = new Attributes();
            $attributes[$i]->setTitle($titles[$i]);
            $attributes[$i]->setResponseType($types[$i]);
            $attributes[$i]->setCategories($categories[$i]);
            $attributes[$i]->setRequired($faker->boolean());
            $manager->persist($attributes[$i]);

            $this->addReference('attributes_' . $i, $attributes[$i]);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoriesFixtures::class,
        ];
    }
}
