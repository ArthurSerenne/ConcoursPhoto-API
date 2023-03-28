<?php

namespace App\DataFixtures;

use App\Entity\Contest;
use App\Entity\Member;
use App\Entity\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $members = $manager->getRepository(Member::class)->findAll();
        $contests = $manager->getRepository(Contest::class)->findAll();

        for ($i = 0; $i < 10; ++$i) {
            $photo = new Photo();
            $photo->setName($faker->name);
            $photo->setStatus($faker->boolean);
            $photo->setFile($faker->imageUrl(640, 480, 'people', true, 'Faker', true));
            $photo->setPrizeRank($faker->numberBetween(1, 10));
            $photo->setPrizeWon($faker->boolean);
            $photo->setVoteCount($faker->numberBetween(1, 200));
            $photo->setSubmissionDate($faker->dateTime);
            $photo->setMember($manager->getReference(Member::class, rand(1, count($members) - 1)));
            $photo->setContest($manager->getReference(Contest::class, rand(1, count($contests) - 1)));
            $manager->persist($photo);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MemberFixtures::class,
            ContestFixtures::class,
        ];
    }
}
