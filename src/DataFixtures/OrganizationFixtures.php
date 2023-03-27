<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Department;
use App\Entity\Organization;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrganizationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = \Faker\Factory::create('fr_FR');

        $cities = $manager->getRepository(City::class)->findAll();

        $departments = $manager->getRepository(Department::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $organization = new Organization();
            $organization->setStatus($faker->boolean);
            $organization->setName($faker->company);
            $organization->setType($faker->text(200));
            $organization->setDescription($faker->text(200));
            $organization->setLogo($faker->imageUrl(640, 480, 'people', true, 'Faker', true));
            $organization->setAddress($faker->address);
            $organization->setCountry('France');
            $organization->setZipCode($manager->getReference(Department::class, rand(1, count($departments) - 1)));
            $organization->setCity($manager->getReference(City::class, rand(1, count($cities) - 1)));
            $organization->setWebsite($faker->url);
            $organization->setEmail($faker->email);
            $organization->setPhone($faker->phoneNumber);
            $manager->persist($organization);
            $this->addReference('organization_' . $i, $organization);
        }

        $manager->flush();
    }
}
