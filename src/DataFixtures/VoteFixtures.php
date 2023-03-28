<?php

namespace App\DataFixtures;

use App\Entity\Member;
use App\Entity\Photo;
use App\Entity\Vote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VoteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = \Faker\Factory::create('fr_FR');

        $members = $manager->getRepository(Member::class)->findAll();
        $photos = $manager->getRepository(Photo::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $vote = new Vote();
            $vote->setDateVote($faker->dateTime);
            $vote->setMember($manager->getReference(Member::class, rand(1, count($members) - 1)));
            $vote->setPhoto($manager->getReference(Photo::class, rand(1, count($photos) - 1)));
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
