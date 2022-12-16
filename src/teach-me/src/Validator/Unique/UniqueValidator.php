<?php

namespace App\Validator\Unique;

use App\Entity\AppEntity;
use App\Validator\Unique\Exception\InvalidColumnNameException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\{ConstraintValidator, Constraint};
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueValidator extends ConstraintValidator
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Unique) {
            throw new UnexpectedTypeException($value, Unique::class);
        }

        if (!is_subclass_of($constraint->entityClass, AppEntity::class)) {
            throw new UnexpectedTypeException(
                $constraint->entityClass,
                AppEntity::class,
            );
        }

        if (null === $value) {
            return;
        }

        if (!property_exists(
            $constraint->entityClass,
            $constraint->columnName,
        )) {
            throw new InvalidColumnNameException(
                $constraint->entityClass,
                $constraint->columnName,
            );
        }

        $repository = $this->entityManager
            ->getRepository($constraint->entityClass);

        if (count($repository->findBy([$constraint->columnName => $value])) > 0) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
