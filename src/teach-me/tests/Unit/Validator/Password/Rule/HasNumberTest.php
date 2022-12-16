<?php

namespace App\Unit\Validator\Password\Rule;

use App\Validator\Password\Configurator\RuleConfigurator;
use App\Validator\Password\Rule\HasNumber;
use PHPUnit\Framework\TestCase;

class HasNumberTest extends TestCase
{
    private HasNumber $rule;

    protected function setUp(): void
    {
        $configurator = $this->createMock(RuleConfigurator::class);

        $this->rule = new HasNumber($configurator);
    }

    public function testIsValidWithNumberShouldReturnTrue(): void
    {
        $this->assertTrue($this->rule->isValid('has_number_9'));
    }

    public function testIsValidWithNoNumberShouldReturnFalse(): void
    {
        $this->assertFalse($this->rule->isValid('has_no_number'));
    }
}
