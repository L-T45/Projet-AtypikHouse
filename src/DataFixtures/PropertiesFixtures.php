<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Properties;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PropertiesFixtures extends Fixture implements DependentFixtureInterface
{


    public function randomNumber($min, $max, $decimal = 15)
    {
        $dec = pow(10, $decimal);
        return   mt_rand($min * $dec, $max * $dec) / $dec;
    }

    public function getSpecificTitle($category)
    {
        // dd($category);
        switch ($category) {
            case 0:
                return ["Manoir d'outre tombe", "Chateau hanté", "Repère maléfique", "Antre du mal"];
            case 1:
                return ["Cabane suspendue", "Cabane au contact de la nature", "Cabane", "Logement suspendu"];
            case 2:
                return ["Tiny House", "Maison minimaliste", "Logement minimal", "Container", "Petite maison", "Logement une personne"];
            case 3:
                return ["Palais", "Manoir", "Petit palais", "Gigantesque barraque", "Grand palais"];
            case 4:
                return ["Grotte", "Grottes de Lascaux", "Stalactite", "La cave", "Le caveaux", "Le paradis du spéléologue"];
            case 5:
                return ["Igloo", "La maison au frais", "Igloo multi-places", "Dome glacé", "La niche"];
            case 6:
                return ["Maison de hobbit", "Maison sous-terraine", "Nid douillet", "Habitat sous-terrain", "Le cocon"];
            case 7:
                return ["Maison bulle", 'La "Sphere"', "Chewing-gum", "La maison bulle"];
            case 8:
                return ["Tipi", "Tente", "Grande tente"];
            case 9:
                return ["Maison futuriste", "Maison du futur", "Galactica"];

            default:
                return ['Maison', 'Cabane', 'Palais', 'Maisonnette'];
        }
    }



    public function load(ObjectManager $manager): void
    {


        // initialisation de l'objet Faker
        $faker = Faker\Factory::create('fr_FR');
        $properties = array();
        // create 20 Properties! Bam!
        for ($i = 1; $i < 150; $i++) {

            $catNbr = $faker->numberBetween(1, 9);
            $category = 'categories_' . $catNbr;


            $categories[$i] =  $this->getReference($category);
            $user[$i] =  $this->getReference('user_' . $faker->numberBetween(1, 23));
            $equipements[$i] =  $this->getReference('equipements_' . $faker->numberBetween(1, 6));

            $properties[$i] = new Properties();
            $properties[$i]->setTitle($faker->randomElement($this->getSpecificTitle($catNbr)));
            $properties[$i]->setSlug($faker->text);
            $properties[$i]->setPrice($faker->numberBetween($min = 20, $max = 200));
            $properties[$i]->setRooms($faker->randomDigitNotNull);
            $properties[$i]->setAddress($faker->streetAddress);
            $properties[$i]->setBooking($faker->randomDigitNotNull);
            $properties[$i]->setCity($faker->city);
            $properties[$i]->setLatitude($this->randomNumber(44.152078777981049, 49.469607001575156, 10));
            $properties[$i]->setLongitude($this->randomNumber(-1.265935156428336, 5.463689062678336, 10));
            $properties[$i]->setBedrooms($faker->randomDigitNotNull);
            $properties[$i]->setSurface($faker->numberBetween($min = 1, $max = 853));
            $properties[$i]->setReference('Categories ' . $i);
            $properties[$i]->setPicture($i . ".webp");
            $properties[$i]->setCountry($faker->country);
            $properties[$i]->setCapacity($faker->randomDigitNotNull);
            $properties[$i]->setZipCode(intval($faker->postcode));
            $properties[$i]->setCategories($categories[$i]);
            $properties[$i]->setUser($user[$i]);
            $properties[$i]->addEquipement($equipements[$i]);
            $manager->persist($properties[$i]);

            // On enregistre les propriétés dans une référence 
            $this->addReference('properties_' . $i, $properties[$i]);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoriesFixtures::class,
            UserFixtures::class,
            EquipementsFixtures::class

        ];
    }
}
