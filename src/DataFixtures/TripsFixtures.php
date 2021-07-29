<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Trips;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TripsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $trip = new Trips();

            $trip->setName($faker->name);
            $trip->setDateStart($faker->dateTimeBetween('-6 months', 'now'));
            $trip->setDuration($faker->numberBetween(1, 10));
            $trip->setLimitRegisterDate($faker->dateTimeBetween('now', '+2 month'));
            $trip->setMaxRegistrations($faker->numberBetween(3, 25));
            $trip->setTripInformations($faker->text(100));


            $manager->persist($trip);
        }

        $manager->flush();
    }
}
