<?php

namespace App\DataFixtures;

use App\Entity\Contest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ContestFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $contest = new Contest();
            $contest->setStatus($faker->boolean);
            $contest->setName($faker->text(200));
            $contest->setVisual($faker->imageUrl(640, 480, 'people', true, 'Faker', true));
            $contest->setDescription($faker->text(200));
            $contest->setRules($faker->text(200));
            $contest->setPrizes($faker->text(200));
            $contest->setCreationDate($faker->dateTimeBetween('-6 months'));
            $contest->setPublicationDate($faker->dateTimeBetween('-3 months'));
            $contest->setSubmissionStartDate($faker->dateTimeBetween('-3 months'));
            $contest->setSubmissionEndDate($faker->dateTimeBetween('-3 months'));
            $contest->setVotingStartDate($faker->dateTimeBetween('-3 months'));
            $contest->setVotingEndDate($faker->dateTimeBetween('-3 months'));
            $contest->setResultsDate($faker->dateTimeBetween('-3 months'));
            $contest->setJuryVotePourcentage($faker->numberBetween(0, 100));
            $contest->setVoteMax($faker->numberBetween(0, 100));
            $contest->setPrizesCount($faker->numberBetween(0, 100));
            $contest->setAgeMin($faker->numberBetween(0, 100));
            $contest->setAgeMax($faker->numberBetween(0, 100));
            $contest->setCountry($faker->country);
            $contest->setOrganization($this->getReference('organization_' . $i));
            $manager->persist($contest);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OrganizationFixtures::class,
        ];
    }
}
