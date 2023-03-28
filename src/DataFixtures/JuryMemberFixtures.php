<?php

namespace App\DataFixtures;

use App\Entity\Contest;
use App\Entity\JuryMember;
use App\Entity\Member;
use App\Enum\FonctionEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class JuryMemberFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $members = $manager->getRepository(Member::class)->findAll();
        $contests = $manager->getRepository(Contest::class)->findAll();

        for ($i = 0; $i < 10; ++$i) {
            $jury = new JuryMember();
            $jury->setMember($manager->getReference(Member::class, rand(1, count($members) - 1)));
            $jury->setContest($manager->getReference(Contest::class, rand(1, count($contests) - 1)));
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
