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
        $titles = ['Proche de la mer', 'Convient aux enfants', 'Convient aux personnes âgées', 'Escapade romantique', 'Silencieux', 'Au contact de la nature'];

        // initialisation de l'objet Faker
        $faker = Faker\Factory::create('fr_FR');
        $attributes = array();
        // create 20 Categories! Bam!
        for ($i = 0; $i < 6; $i++) {

            $categories[$i] =  $this->getReference('categories_' . $faker->numberBetween(1, 8));

            $attributes[$i] = new Attributes();
            $attributes[$i]->setTitle($titles[$i]);
            $attributes[$i]->setCategories($categories[$i]);
            $attributes[$i]->setRequired(false);
            $attributes[$i]->setResponseString(false);
            $attributes[$i]->setResponseBool(false);
            $attributes[$i]->setResponseNbr(false);
            $attributes[$i]->setResponseType(false);
            $manager->persist($attributes[$i]);
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
