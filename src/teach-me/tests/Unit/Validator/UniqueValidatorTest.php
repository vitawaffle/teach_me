<?php

namespace App\Unit\Validator;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Validator\Unique\{Unique, UniqueValidator};
use App\Validator\Unique\Exception\InvalidColumnNameException;
use Doctrine\ORM\EntityManagerInterface;
use stdClass;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class UniqueValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): UniqueValidator
    {
        $userRepository = $this->createMock(UserRepository::class);

        $userRepository->expects($this->any())
            ->method('findBy')
            ->willReturnCallback(fn (array $criteria) => match ($criteria) {
                ['username' => 'test_user_1'] => [new User(
                    username: 'test_user_1',
                    password: 'secret',
                    id: 1,
                )],
                default => [],
            });

        $entityManager = $this->createMock(EntityManagerInterface::class);

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturnCallback(fn (string $entityClass) => match ($entityClass) {
                User::class => $userRepository,
                default => null,
            });

        return new UniqueValidator($entityManager);
    }

    public function testValidateWithInvalidConstraintTypeShouldThrowsUnexpectedTypeException(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(null, new class() extends Constraint {
        });
    }

    public function testValidateWithInvalidEntityClassShouldThrowsUnexpectedTypeException(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(null, new Unique(
            entityClass: stdClass::class,
            columnName: 'test',
        ));
    }

    public function testValidateWithNullValueShouldBeNoViolation(): void
    {
        $this->validator->validate(null, new Unique(
            entityClass: User::class,
            columnName: 'username',
        ));

        $this->assertNoViolation();
    }

    public function testValidateWithNotExistingPropertyShouldThrowsInvalidColumnNameException(): void
    {
        $this->expectException(InvalidColumnNameException::class);

        $this->validator->validate('', new Unique(
            entityClass: User::class,
            columnName: 'notExistingProperty',
        ));
    }

    public function testValidateWithNotExistingColumnValueShouldBeNoViolation(): void
    {
        $this->validator->validate('not_existing_user', new Unique(
            entityClass: User::class,
            columnName: 'username',
        ));

        $this->assertNoViolation();
    }

    public function testValidateWithExistingColumnValueShouldRaised(): void
    {
        $this->validator->validate('test_user_1', new Unique(
            entityClass: User::class,
            columnName: 'username',
        ));

        $this->assertRaised('test_user_1');
    }

    private function assertRaised(string $value): void
    {
        $this->buildViolation('The value {{ string }} must be unique')
            ->setParameter('{{ string }}', $value)
            ->assertRaised();
    }
}
