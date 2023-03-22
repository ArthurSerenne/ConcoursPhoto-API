<?php

namespace App\DataFixtures;

use App\Entity\Member;
use App\Entity\SocialNetwork;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MemberFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1; $i < 10; $i++) {
            $member = new Member();
            $member->setStatus($faker->boolean);
            $member->setUsername($faker->userName);
            $member->setRegistrationDate($faker->dateTimeBetween('-6 months'));
            $member->setDeletionDate($faker->dateTimeBetween('-3 months'));
            $member->setUpdateDate($faker->dateTimeBetween('-3 months'));
            $member->setLastLoginDate($faker->dateTimeBetween('-3 months'));
            $member->setPhoto($faker->imageUrl(640, 480, 'people', true, 'Faker', true));
            $member->setDescription($faker->text(200));
            $member->setSituation($faker->text(200));
            $member->setCategory($faker->text(200));
            $member->setWebsite($faker->url);
            $member->setUser($this->getReference('user_' . $i));
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
