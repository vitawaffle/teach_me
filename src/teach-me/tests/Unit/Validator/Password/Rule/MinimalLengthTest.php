<?php

namespace App\Unit\Password\Rule;

use App\Validator\Password\Configurator\RuleConfigurator;
use App\Validator\Password\Rule\MinimalLength;
use PHPUnit\Framework\TestCase;

class MinimalLengthTest extends TestCase
{
    private RuleConfigurator $configurator;
    private MinimalLength $rule;

    public function setUp(): void
    {
        $this->configurator = $this->createMock(RuleConfigurator::class);

        $this->rule = new MinimalLength($this->configurator);
    }

    public function testIsActiveWithNullValueShouldReturnFalse(): void
    {
        $this->configurator->expects($this->once())
            ->method('getValue')
            ->willReturn(null);

        $this->assertFalse($this->rule->isActive());
    }

    public function testIsActiveWithNotNullValueShouldReturnTrue(): void
    {
        $this->configurator->expects($this->once())
            ->method('getValue')
            ->willReturn('123');

        $this->assertTrue($this->rule->isActive());
    }

    public function testIsValidWithNotIntegerValueShouldCast(): void
    {
        $this->configurator->expects($this->once())
            ->method('getValue')
            ->willReturn('2a');

        $this->assertTrue($this->rule->isValid('sec'));
    }

    public function testIsValidWithLongerOrEqualThanMinimalLengthShouldReturnTrue(): void
    {
        $this->configurator->expects($this->once())
            ->method('getValue')
            ->willReturn(8);

        $this->assertTrue($this->rule->isValid('secret12'));
    }

    public function testIsValidWithShorterThanMinimalLengthShouldReturnFalse(): void
    {
        $this->configurator->expects($this->once())
            ->method('getValue')
            ->willReturn(8);

        $this->assertFalse($this->rule->isValid('short'));
    }
}
