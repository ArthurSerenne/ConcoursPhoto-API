<?php

namespace App\DataFixtures;

use App\Entity\JuryMember;
use App\Enum\FonctionEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class JuryMemberFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; ++$i) {
            $jury = new JuryMember();
            $jury->setMember($this->getReference('member_'.$faker->numberBetween(0, 9)));
            $jury->setContest($this->getReference('contest_'.$faker->numberBetween(0, 9)));
            $jury->setFonction(FonctionEnum::cases()[array_rand(FonctionEnum::cases())]->value);
            $jury->setAcceptanceDate($faker->dateTime);
            $jury->setInvitationDate($faker->dateTime);
            $manager->persist($jury);
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
