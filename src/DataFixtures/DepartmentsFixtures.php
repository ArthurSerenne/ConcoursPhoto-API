<?php

namespace App\DataFixtures;

use App\Entity\Departments;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepartmentsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $department = new Departments();
            $department->setRegionCode($faker->numberBetween(1, 20));
            $department->setCode($faker->numberBetween(1, 100));
            $department->setName($faker->city);
            $department->setSlug($faker->slug);
            $manager->persist($department);
            $this->addReference('department_' . $i, $department);
        }

        $manager->flush();
    }
}
