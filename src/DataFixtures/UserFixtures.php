<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Department;
use App\Entity\User;
use App\Enum\GenderEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $cities = $manager->getRepository(City::class)->findAll();

        $departments = $manager->getRepository(Department::class)->findAll();

        // ROLE_USER
        for ($i = 0; $i < 10; ++$i) {
            $user = new User();
            $user->setStatus($faker->boolean);
            $user->setCreationDate($faker->dateTimeBetween('-6 months'));
            $user->setGender(GenderEnum::cases()[array_rand(GenderEnum::cases())]->value);
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setBirthdate($faker->dateTimeBetween('-60 years', '-18 years'));
            $user->setAddress($faker->address);
            $user->setZipCode($manager->getReference(Department::class, rand(1, count($departments) - 1)));
            $user->setCity($manager->getReference(City::class, rand(1, count($cities) - 1)));
            $user->setCountry($faker->countryCode);
            $user->setEmail($faker->email);
            $user->setPhone($faker->phoneNumber);
            $password = $this->hasher->hashPassword($user, 'xxx');
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $this->addReference('user_'.$i, $user);
        }

        // ROLE_SUPER_ADMIN
        $user = new User();
        $user->setStatus($faker->boolean);
        $user->setCreationDate($faker->dateTimeBetween('-6 months'));
        $user->setGender(GenderEnum::cases()[array_rand(GenderEnum::cases())]->value);
        $user->setFirstname($faker->firstName);
        $user->setLastname($faker->lastName);
        $user->setBirthdate($faker->dateTimeBetween('-60 years', '-18 years'));
        $user->setAddress($faker->address);
        $user->setZipCode($manager->getReference(Department::class, rand(1, count($departments) - 1)));
        $user->setCity($manager->getReference(City::class, rand(1, count($cities) - 1)));
        $user->setCountry($faker->countryCode);
        $user->setEmail('test@mailinator.com');
        $user->setPhone($faker->phoneNumber);
        $password = $this->hasher->hashPassword($user, 'xxx');
        $user->setPassword($password);
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
