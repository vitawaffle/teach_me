<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\{Fixture, FixtureGroupInterface};
use Doctrine\Persistence\ObjectManager;

class TestRoleFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist(new Role(
            name: 'TEST_ROLE_1',
        ));
        $manager->persist(new Role(
            name: 'TEST_ROLE_2',
        ));
        $manager->persist(new Role(
            name: 'TEST_ROLE_3',
        ));

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
