<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepartmentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $conn = $manager->getConnection();
        $conn->beginTransaction();

        try {
            $sql = file_get_contents(__DIR__ . '/../sql/departments.sql');
            $conn->executeUpdate($sql);

            $conn->commit();
        } catch (\Exception $e) {
            $conn->rollback();
            throw $e;
        }
    }
}
