<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\AttributesAnswers;

use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AttributesAnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {


        $faker = Faker\Factory::create('fr_FR');
        $attributes = [];


        for ($i = 1; $i < 100; $i++) {
            $RandomObject = $faker->randomElement([1, 2, 3]);
            $attributes[$i] =  $this->getReference('attributes_' . $faker->numberBetween(1, 9));
            $properties[$i] = $this->getReference('properties_' . $i);

            $attribute[$i] = new AttributesAnswers();

            if ($RandomObject === 1) {
                $attribute[$i]->setResponseBool($faker->boolean());
                $attribute[$i]->setResponseNbr(null);
                $attribute[$i]->setResponseString(null);
            }

            if ($RandomObject === 2) {
                $attribute[$i]->setResponseBool(null);
                $attribute[$i]->setResponseNbr($faker->numberBetween($min = 1, $max = 200));
                $attribute[$i]->setResponseString(null);
            }
            if ($RandomObject === 3) {
                $attribute[$i]->setResponseBool(null);
                $attribute[$i]->setResponseNbr(null);
                $attribute[$i]->setResponseString($faker->text(15));
            }


            $attribute[$i]->setAttributes($attributes[$i]);
            $attribute[$i]->setProperties($properties[$i]);
            $manager->persist($attribute[$i]);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            AttributesFixtures::class,
        ];
    }
}
