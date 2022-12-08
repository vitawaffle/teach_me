<?php

namespace App\Functional\Repository;

use App\Entity\{User, Role};
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;
    private UserRepository $repository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        
        $this->repository = $this->entityManager
            ->getRepository(User::class);
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
            'username' => 'test_user_1',
        ]));
    }

    public function testFindOneByWithNotExistingCriteriaReturnNull(): void
    {
        self::assertNull($this->repository->findOneBy([
            'username' => 'not_existing_user',
        ]));
    }

    public function testFindAllShouldReturnNotEmpty(): void
    {
        self::assertTrue(count($this->repository->findAll()) > 0);
    }

    public function testFindByWithExistingCriteriaShouldReturnNotEmpty(): void
    {
        self::assertTrue(count($this->repository->findBy([
            'username' => 'test_user_1',
        ])) > 0);
    }

    public function testFindByWithNotExistingCriteriaShouldReturnEmpty(): void
    {
        self::assertFalse(count($this->repository->findBy([
            'username' => 'not_existing_user',
        ])) > 0);
    }

    public function testFindOneByNameWithExistingNameShouldReturnNotNull(): void
    {
        self::assertNotNull($this->repository->findOneByUsername('test_user_1'));
    }

    public function testFindOneByNameWithNotExistingNameShouldReturnNull(): void
    {
        self::assertNull($this->repository->findOneByUsername('not_existing_user'));
    }

    public function testSaveShouldSave(): void
    {
        $this->repository->save(new User(
            username: 'test_user',
            password: 'secret',
        ), true);

        self::assertNotNull($this->repository->findOneByUsername('test_user'));
    }

    public function testRemoveShouldRemove(): void
    {
        $role = $this->repository->findOneByUsername('test_user_1');

        $this->repository->remove($role, true);

        self::assertNull($this->repository->findOneByUsername('test_user_1'));
    }
}
