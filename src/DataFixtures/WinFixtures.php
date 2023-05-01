<?php

namespace App\DataFixtures;

use App\Entity\Win;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class WinFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; ++$i) {
            $win = new Win();
            $win->setPriceRank($faker->numberBetween(1, 10));
            $win->setContest($this->getReference('contest_'.$i));
            $win->setPhoto($this->getReference('photo_'.$i));
            $manager->persist($win);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ContestFixtures::class,
            PhotoFixtures::class,
        ];
    }
}
