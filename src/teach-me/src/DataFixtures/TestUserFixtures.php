<?php

namespace App\DataFixtures;

use App\Entity\{User, Role};
use Doctrine\Bundle\FixturesBundle\{Fixture, FixtureGroupInterface};
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TestUserFixtures extends Fixture implements
    FixtureGroupInterface,
    DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $roleRepository = $manager->getRepository(Role::class);

        $manager->persist(new User(
            username: 'test_user_1',
            password: 'Secret1',
            roles: [$roleRepository->findOneByName('TEST_ROLE_1')],
        ));
        $manager->persist(new User(
            username: 'test_user_2',
            password: 'Secret2',
            roles: [$roleRepository->findOneByName('TEST_ROLE_2')],
        ));
        $manager->persist(new User(
            username: 'test_user_3',
            password: 'Secret3',
            roles: [$roleRepository->findOneByName('TEST_ROLE_3')],
        ));

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }

    public function getDependencies(): array
    {
        return [TestRoleFixtures::class];
    }
}
