<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $property = new Property();
            $property
                ->setAddress($faker->address())
                ->setBedrooms($faker->numberBetween(1, 6))
                ->setCity($faker->city())
                ->setCreatedAt($faker->DateTime())
                ->setDescription($faker->paragraph())
                ->setHeat($faker->numberBetween(0, count(Property::HEAT) - 1))
                ->setPostalCode((int) $faker->postcode())
                ->setPrice($faker->numberBetween(50000, 500000))
                ->setRooms($faker->numberBetween(1, 12))
                ->setSold(false)
                ->setSurface($faker->numberBetween(20, 400))
                ->setTitle($faker->words(5, true));
            $manager->persist($property);
        }

        $manager->flush();
    }
}
