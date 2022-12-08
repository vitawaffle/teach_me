<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\{Fixture, FixtureGroupInterface};
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist(new Role(
            name: 'STUDENT',
        ));
        $manager->persist(new Role(
            name: 'TEACHER',
        ));
        $manager->persist(new Role(
            name: 'MODERATOR',
        ));
        $manager->persist(new Role(
            name: 'ADMIN',
        ));

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['default'];
    }
}
