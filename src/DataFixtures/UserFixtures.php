<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setStatus($faker->boolean);
            $user->setCreationDate($faker->dateTimeBetween('-6 months'));
            $user->setGender($faker->title);
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setBirthdate($faker->dateTimeBetween('-60 years', '-18 years'));
            $user->setAddress($faker->address);
            $user->setZipCode($this->getReference('department_' . $i));
            $user->setCity($this->getReference('city_' . $i));
            $user->setCountry($faker->country);
            $user->setEmail($faker->email);
            $user->setPhone($faker->phoneNumber);
            $user->setPassword($faker->password);
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CitiesFixtures::class,
            DepartmentsFixtures::class,
        ];
    }
}
