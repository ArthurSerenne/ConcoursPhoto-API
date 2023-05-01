<?php

namespace App\DataFixtures;

use App\Entity\Vote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VoteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; ++$i) {
            $vote = new Vote();
            $vote->setDateVote($faker->dateTime);
            $vote->setMember($this->getReference('member_'.$faker->numberBetween(0, 9)));
            $vote->setPhoto($this->getReference('photo_'.$faker->numberBetween(0, 9)));
            $manager->persist($vote);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MemberFixtures::class,
            PhotoFixtures::class,
        ];
    }
}
