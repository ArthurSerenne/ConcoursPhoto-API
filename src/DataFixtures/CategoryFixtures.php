<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = [
            'Ouvert à tous',
            'Jeunesse',
            'Adulte',
            'Evènement',
            'Famille',
            'Amitiés',
            'Couples',
            'Passions',
            'Groupes',
            'Vie',
        ];

        foreach ($category as $index => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference('category_'.$index, $category);
        }

        $manager->flush();
    }
}
