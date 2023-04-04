<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; ++$i) {
            $photo = new Photo();
            $photo->setName($faker->name);
            $photo->setStatus($faker->boolean);
            $photo->setFile($faker->imageUrl(640, 480, 'people', true, 'Faker', true));
            $photo->setPrizeRank($faker->numberBetween(1, 10));
            $photo->setPrizeWon($faker->boolean);
            $photo->setVoteCount($faker->numberBetween(1, 200));
            $photo->setSubmissionDate($faker->dateTime);
            $photo->setMember($this->getReference('member_'. $faker->numberBetween(0, 9)));
            $photo->setContest($this->getReference('contest_'. $faker->numberBetween(0, 9)));
            $this->addReference('photo_'.$i, $photo);
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
