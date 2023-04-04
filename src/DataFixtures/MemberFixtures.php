<?php

namespace App\DataFixtures;

use App\Entity\Member;
use App\Entity\SocialNetwork;
use App\Enum\CategoryEnum;
use App\Enum\SituationEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MemberFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; ++$i) {
            $member = new Member();
            $member->setStatus($faker->boolean);
            $member->setUsername($faker->userName);
            $member->setRegistrationDate($faker->dateTimeBetween('-6 months'));
            $member->setDeletionDate($faker->dateTimeBetween('-3 months'));
            $member->setUpdateDate($faker->dateTimeBetween('-3 months'));
            $member->setLastLoginDate($faker->dateTimeBetween('-3 months'));
            $member->setPhoto($faker->imageUrl(640, 480, 'people', true, 'Faker', true));
            $member->setDescription($faker->text(200));
            $member->setSituation(SituationEnum::cases()[array_rand(SituationEnum::cases())]->value);
            $member->setCategory(CategoryEnum::cases()[array_rand(CategoryEnum::cases())]->value);
            $member->setWebsite($faker->url);
            $member->setUser($this->getReference('user_'.$i));
            $manager->persist($member);
            $socialNetwork = new SocialNetwork();
            $socialNetwork->setMember($member);
            $socialNetwork->setFacebook($faker->url());
            $socialNetwork->setInstagram($faker->url());
            $socialNetwork->setTiktok($faker->url());
            $socialNetwork->setTwitter($faker->url());
            $socialNetwork->setLinkedin($faker->url());
            $socialNetwork->setSnapchat($faker->url());
            $socialNetwork->setYoutube($faker->url());
            $socialNetwork->setWhatsapp($faker->url());
            $this->addReference('member_'.$i, $member);
            $manager->persist($socialNetwork);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
