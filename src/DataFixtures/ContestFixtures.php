<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Contest;
use App\Entity\Department;
use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ContestFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $cities = $manager->getRepository(City::class)->findAll();
        $departments = $manager->getRepository(Department::class)->findAll();
        $regions = $manager->getRepository(Region::class)->findAll();

        for ($i = 0; $i < 10; ++$i) {
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
            $contest->setCountry($faker->countryCode);
            $contest->setOrganization($this->getReference('organization_'.$i));
            $contest->addCity($manager->getReference(City::class, rand(1, count($cities) - 1)));
            $contest->addDepartment($manager->getReference(Department::class, rand(1, count($departments) - 1)));
            $contest->addRegion($manager->getReference(Region::class, rand(1, count($regions) - 1)));
            $contest->addCategory($this->getReference('category_'.$faker->numberBetween(0, 9)));
            $contest->addTheme($this->getReference('theme_'.$faker->numberBetween(0, 9)));
            $contest->setTrend($faker->boolean);
            $this->addReference('contest_'.$i, $contest);
            $manager->persist($contest);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OrganizationFixtures::class,
            ThemeFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
