<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Property;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 100;$i++){
            $property = new Property();
            $property->setTitle($faker->words(3,true))
                        ->setDescription($faker->sentences(3,true))
                        ->setSurface($faker->numberBetween(10,400))
                        ->setFloor($faker->randomDigitNot(0))
                        ->setPrice($faker->numberBetween(50000,1000000))
                        ->setRooms($faker->numberBetween(1,30))
                        ->setBedRooms($faker->numberBetween(1,30))
                        ->setPostalCode($faker->postcode())
                        ->setCity($faker->city())
                        ->setAdress($faker->Address())
                        ->setHeat($faker->numberBetween(0,count(Property::HEAT)-1))
                        ->setSold(false);
            $manager->persist($property);
        }

        $manager->flush();
    }
}
