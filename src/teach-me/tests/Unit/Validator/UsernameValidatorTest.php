<?php

namespace App\Unit\Validator;

use App\Validator\Username\{UsernameValidator, Username};
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\{
    UnexpectedTypeException,
    UnexpectedValueException,
};
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class UsernameValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): UsernameValidator
    {
        return new UsernameValidator();
    }

    public function testValidateWithInvalidConstraintTypeShouldThrowUnexpectedTypeException(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(null, new class() extends Constraint {
        });
    }

    public function testValidateWithNullValueShouldBeNoViolation(): void
    {
        $this->validator->validate(null, new Username());

        $this->assertNoViolation();
    }

    public function testValidateWithBlankValueShouldBeNoViolation(): void
    {
        $this->validator->validate('', new Username());

        $this->assertNoViolation();
    }

    public function testValidateWithInvalidValueTypeShouldThrowsUnexpectedValueException(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $this->validator->validate(12345, new Username());
    }

    public function testValidateWithValidValueShouldBeNoViolation(): void
    {
        $this->validator->validate('username_1', new Username());

        $this->assertNoViolation();
    }

    public function testValidateWithInvalidSymbolShouldRaised(): void
    {
        $invalidSymbolUsername = 'пользователь_1';

        $this->validator->validate($invalidSymbolUsername, new Username());

        $this->assertRaised($invalidSymbolUsername);
    }

    private function assertRaised(string $value): void
    {
        $this->buildViolation('Username {{ string }} has invalid format')
            ->setParameter('{{ string }}', $value)
            ->assertRaised();
    }

    public function testValidateWithLongerThen32SymbolsUsernameShouldRaised(): void
    {
        $longerThen32SymbolsUsername = 'very_very_very_very_long_username';

        $this->validator->validate($longerThen32SymbolsUsername, new Username());

        $this->assertRaised($longerThen32SymbolsUsername);
    }
}
