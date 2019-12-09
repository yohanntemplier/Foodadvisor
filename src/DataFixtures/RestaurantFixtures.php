<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class RestaurantFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i=0; $i<10 ; $i++) {
            $restaurant = new Restaurant();
            $restaurant
                ->setName($faker->company)
                ->setType($faker->words(2, true))
                ->setAddress($faker->address)
                ->setCity($faker->city)
                ->setPostalCode($faker->postcode)
                ->setSite($faker->url)
                ->setCost($faker->numberBetween(5,40));
            $manager->persist($restaurant);
        }

        $manager->flush();
    }
}
