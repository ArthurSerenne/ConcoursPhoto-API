<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $sql = file_get_contents(__DIR__ . '/../sql/cities.sql');
        $manager->getConnection()->exec($sql);
    }
}

