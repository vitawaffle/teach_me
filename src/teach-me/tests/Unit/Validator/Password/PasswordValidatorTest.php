<?php

namespace App\Unit\Validator\Password;

use App\Validator\Password\{PasswordValidator, RuleProvider, Password};
use App\Validator\Password\Rule\Rule;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\{
    UnexpectedTypeException,
    UnexpectedValueException,
};
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class PasswordValidatorTest extends ConstraintValidatorTestCase
{
    private RuleProvider $ruleProvider;

    protected function createValidator(): PasswordValidator
    {
        $this->ruleProvider = $this->createMock(RuleProvider::class);

        return new PasswordValidator($this->ruleProvider);
    }

    public function testValidateWithInvalidConstraintTypeShouldThrowsUnexpectedTypeException(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(null, new class() extends Constraint {
        });
    }

    public function testValidateWithNullValueShouldBeNoViolation(): void
    {
        $this->validator->validate(null, new Password());

        $this->assertNoViolation();
    }

    public function testValidateWithBlankValueShouldBeNoViolation(): void
    {
        $this->validator->validate('', new Password());

        $this->assertNoViolation();
    }

    public function testValidateWithInvalidValueTypeShouldThrowsUnexpectedValueException(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $this->validator->validate(12345, new Password());
    }

    public function testValidateWithValidRuleShouldBeNoValidation(): void
    {
        $this->ruleProvider->expects($this->once())
            ->method('getRules')
            ->willReturn([
                new class() implements Rule {
                    public function isActive(): bool
                    {
                        return true;
                    }

                    public function isValid(string $value): bool
                    {
                        return true;
                    }
                },
            ]);

        $this->validator->validate('secret', new Password());

        $this->assertNoViolation();
    }

    public function testValidateWithInvalidNotActiveRuleShouldBeNoViolation(): void
    {
        $this->ruleProvider->expects($this->once())
            ->method('getRules')
            ->willReturn([
                new class() implements Rule {
                    public function isActive(): bool
                    {
                        return true;
                    }

                    public function isValid(string $value): bool
                    {
                        return true;
                    }
                },
                new class() implements Rule {
                    public function isActive(): bool
                    {
                        return false;
                    }

                    public function isValid(string $value): bool
                    {
                        return false;
                    }
                }
            ]);

        $this->validator->validate('secret', new Password());

        $this->assertNoViolation();
    }

    public function testValidateWithNoRulesShouldBeNoViolation(): void
    {
        $this->ruleProvider->expects($this->once())
            ->method('getRules')
            ->willReturn([]);

        $this->validator->validate('secret', new Password());

        $this->assertNoViolation();
    }

    public function testValidateWithNoActiveRulesShouldBeNoViolation(): void
    {
        $this->ruleProvider->expects($this->once())
            ->method('getRules')
            ->willReturn([
                new class() implements Rule {
                    public function isActive(): bool
                    {
                        return false;
                    }

                    public function isValid(string $value): bool
                    {
                        return false;
                    }
                }
            ]);

        $this->validator->validate('secret', new Password());

        $this->assertNoViolation();
    }

    public function testValidateWithActiveInvalidRuleShouldRaised(): void
    {
        $this->ruleProvider->expects($this->once())
            ->method('getRules')
            ->willReturn([
                new class() implements Rule {
                    public function isActive(): bool
                    {
                        return true;
                    }

                    public function isValid(string $value): bool
                    {
                        return true;
                    }
                },
                new class() implements Rule {
                    public function isActive(): bool
                    {
                        return true;
                    }

                    public function isValid(string $value): bool
                    {
                        return false;
                    }
                },
            ]);

        $this->validator->validate('secret', new Password());

        $this->assertRaised('secret');
    }

    private function assertRaised(string $value): void
    {
        $this->buildViolation('Password {{ string }} has invalid format')
            ->setParameter('{{ string }}', $value)
            ->assertRaised();
    }
}
