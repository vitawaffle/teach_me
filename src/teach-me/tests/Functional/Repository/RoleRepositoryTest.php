<?php

namespace App\Functional\Repository;

use App\Entity\Role;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RoleRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;
    private RoleRepository $repository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        
        $this->repository = $this->entityManager
            ->getRepository(Role::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testFindWithExistingIdShouldReturnNotNull(): void
    {
        self::assertNotNull($this->repository->find(1));
    }

    public function testFindWithNotExistingIdShouldReturnNull(): void
    {
        self::assertNull($this->repository->find(0));
    }

    public function testFindOneByWithExistingCriteriaReturnNotNull(): void
    {
        self::assertNotNull($this->repository->findOneBy([
            'name' => 'TEST_ROLE_1',
        ]));
    }

    public function testFindOneByWithNotExistingCriteriaReturnNull(): void
    {
        self::assertNull($this->repository->findOneBy([
            'name' => 'NOT_EXISTING_ROLE',
        ]));
    }

    public function testFindAllShouldReturnNotEmpty(): void
    {
        self::assertTrue(count($this->repository->findAll()) > 0);
    }

    public function testFindByWithExistingCriteriaShouldReturnNotEmpty(): void
    {
        self::assertTrue(count($this->repository->findBy([
            'name' => 'TEST_ROLE_1',
        ])) > 0);
    }

    public function testFindByWithNotExistingCriteriaShouldReturnEmpty(): void
    {
        self::assertFalse(count($this->repository->findBy([
            'name' => 'NOT_EXISTING_ROLE',
        ])) > 0);
    }

    public function testFindOneByNameWithExistingNameShouldReturnNotNull(): void
    {
        self::assertNotNull($this->repository->findOneByName('TEST_ROLE_1'));
    }

    public function testFindOneByNameWithNotExistingNameShouldReturnNull(): void
    {
        self::assertNull($this->repository->findOneByName('NOT_EXISTING_NAME'));
    }

    public function testSaveShouldSave(): void
    {
        $this->repository->save(new Role(
            name: 'TEST_ROLE',
        ), true);

        self::assertNotNull($this->repository->findOneByName('TEST_ROLE'));
    }

    public function testRemoveShouldRemove(): void
    {
        $role = $this->repository->findOneByName('TEST_ROLE_1');

        $this->repository->remove($role, true);

        self::assertNull($this->repository->findOneByName('TEST_ROLE_1'));
    }
}
