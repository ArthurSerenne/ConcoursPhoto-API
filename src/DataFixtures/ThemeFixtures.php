<?php

namespace App\DataFixtures;

use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ThemeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $themes = [
            'Nature',
            'Urbanisme',
            'Fleurs',
            'Sports',
            'Voitures',
            'Batiments',
            'Paysages',
            'Univers',
            'Tourisme',
            'Métiers',
        ];

        foreach ($themes as $index => $themeName) {
            $theme = new Theme();
            $theme->setName($themeName);
            $manager->persist($theme);
            $this->addReference('theme_'.$index, $theme);
        }

        $manager->flush();
    }
    // public function load(ObjectManager $manager): void
    // {
    //     $faker = \Faker\Factory::create('fr_FR');

    //     for ($i = 0; $i < 10; ++$i) {
    //         $theme = new Theme();
    //         $theme->setName($faker->word);
    //         $manager->persist($theme);
    //         $this->addReference('theme_'.$i, $theme);
    //     }

    //     $manager->flush();
    // }
}
