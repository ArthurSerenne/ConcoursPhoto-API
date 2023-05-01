<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Department;
use App\Entity\Organization;
use App\Enum\OrganizationTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrganizationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $cities = $manager->getRepository(City::class)->findAll();
        $departments = $manager->getRepository(Department::class)->findAll();

        for ($i = 0; $i < 10; ++$i) {
            $organization = new Organization();
            $organization->setStatus($faker->boolean);
            $organization->setName($faker->company);
            $organization->setType(OrganizationTypeEnum::cases()[array_rand(OrganizationTypeEnum::cases())]->value);
            $organization->setDescription($faker->text(200));
            $organization->setLogo($faker->imageUrl(640, 480, 'people', true, 'Faker', true));
            $organization->setAddress($faker->address);
            $organization->setCountry($faker->countryCode);
            $organization->setZipCode($manager->getReference(Department::class, rand(1, count($departments) - 1)));
            $organization->setCity($manager->getReference(City::class, rand(1, count($cities) - 1)));
            $organization->setWebsite($faker->url);
            $organization->setEmail($faker->email);
            $organization->setPhone($faker->phoneNumber);
            $organization->setSiret($faker->numberBetween(1, 110));
            $organization->setVat($faker->numberBetween(0, 100));
            $organization->addUser($this->getReference('user_'.$i));
            $manager->persist($organization);
            $this->addReference('organization_'.$i, $organization);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
