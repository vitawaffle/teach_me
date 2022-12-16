<?php

namespace App\Unit\Validator\Password\Rule;

use App\Validator\Password\Configurator\RuleConfigurator;
use App\Validator\Password\Rule\HasBigLetter;
use PHPUnit\Framework\TestCase;

class HasBigLetterTest extends TestCase
{
    private RuleConfigurator $configurator;
    private HasBigLetter $rule;

    protected function setUp(): void
    {
        $this->configurator = $this->createMock(RuleConfigurator::class);

        $this->rule = new HasBigLetter($this->configurator);
    }

    public function testIsActiveWithNullValueShouldReturnFalse(): void
    {
        $this->configurator->expects($this->once())
            ->method('getValue')
            ->willReturnCallback(fn ($key) => match ($key) {
                default => null,
            });

        $this->assertFalse($this->rule->isActive());
    }

    public function testIsActiveWithTrueValueShouldReturnTrue(): void
    {
        $this->configurator->expects($this->once())
            ->method('getValue')
            ->willReturnCallback(fn ($key) => match ($key) {
                'hasBigLetter' => true,
                default => null,
            });

        $this->assertTrue($this->rule->isActive());
    }

    public function testIsActiveWith1ValueShouldReturnTrue(): void
    {
        $this->configurator->expects($this->once())
            ->method('getValue')
            ->willReturnCallback(fn ($key) => match ($key) {
                'hasBigLetter' => 1,
                default => null,
            });

        $this->assertTrue($this->rule->isActive());
    }

    public function testIsActiveWithTrueStringValueShouldReturnTrue(): void
    {
        $this->configurator->expects($this->once())
            ->method('getValue')
            ->willReturnCallback(fn ($key) => match ($key) {
                'hasBigLetter' => 'True',
                default => null,
            });

        $this->assertTrue($this->rule->isActive());
    }

    public function testIsActiveWith1StringValueShouldReturnTrue(): void
    {
        $this->configurator->expects($this->once())
            ->method('getValue')
            ->willReturnCallback(fn ($key) => match ($key) {
                'hasBigLetter' => '1',
                default => null,
            });

        $this->assertTrue($this->rule->isActive());
    }

    public function testIsActiveWithYStringValueShouldReturnTrue(): void
    {
        $this->configurator->expects($this->once())
            ->method('getValue')
            ->willReturnCallback(fn ($key) => match ($key) {
                'hasBigLetter' => 'Y',
                default => null,
            });

        $this->assertTrue($this->rule->isActive());
    }

    public function testIsActiveWithYesStringValueShouldReturnTrue(): void
    {
        $this->configurator->expects($this->once())
            ->method('getValue')
            ->willReturnCallback(fn ($key) => match ($key) {
                'hasBigLetter' => 'Yes',
                default => null,
            });

        $this->assertTrue($this->rule->isActive());
    }

    public function testIsActiveWithAnotherValueShouldReturnTrue(): void
    {
        $this->configurator->expects($this->once())
            ->method('getValue')
            ->willReturnCallback(fn ($key) => match ($key) {
                'hasBigLetter' => 'aaa',
                default => null,
            });

        $this->assertFalse($this->rule->isActive());
    }

    public function testIsValidWithBigLetterShouldReturnTrue(): void
    {
        $this->assertTrue($this->rule->isValid('HAS_big_letter'));
    }

    public function testIsValidWithNoBigLetterShouldReturnFalse(): void
    {
        $this->assertFalse($this->rule->isValid('no_big_letter'));
    }
}
