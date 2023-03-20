<?php

namespace App\DataFixtures;

use App\Entity\Cities;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CitiesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $city = new Cities();
            $city->setDepartmentCode($faker->numberBetween(1, 100));
            $city->setInseeCode($faker->numberBetween(1, 100));
            $city->setZipCode($faker->numberBetween(1, 100));
            $city->setName($faker->city);
            $city->setSlug($faker->slug);
            $city->setGpsLat($faker->latitude);
            $city->setGpsLng($faker->longitude);
            $manager->persist($city);
            $this->addReference('city_' . $i, $city);
        }

        $manager->flush();
    }
}
