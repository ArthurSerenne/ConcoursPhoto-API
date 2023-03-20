<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
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
            $user->setZipCode($faker->randomNumber(5));
            $user->setCity($faker->city);
            $user->setCountry($faker->country);
            $user->setEmail($faker->email);
            $user->setPhone($faker->phoneNumber);
            $user->setPassword($faker->password);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
