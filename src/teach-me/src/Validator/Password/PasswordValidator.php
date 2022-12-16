<?php

namespace App\Validator\Password;

use Symfony\Component\Validator\{ConstraintValidator, Constraint};
use Symfony\Component\Validator\Exception\{
    UnexpectedTypeException,
    UnexpectedValueException,
};

class PasswordValidator extends ConstraintValidator
{
    public function __construct(
        private readonly RuleProvider $ruleProvider,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!($constraint instanceof Password)) {
            throw new UnexpectedTypeException($constraint, Username::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $activeRules = array_filter(
            $this->ruleProvider->getRules(),
            fn ($rule) => $rule->isActive(),
        );

        $ruleValidations = array_map(
            fn ($rule) => $rule->isValid($value),
            $activeRules,
        );

        $invalidRuleValidations = array_filter(
            $ruleValidations,
            fn ($isValid) => !$isValid,
        );

        if (count($invalidRuleValidations) > 0) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
