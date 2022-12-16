<?php

namespace App\Unit\Validator\Password\Rule;

use App\Validator\Password\Configurator\RuleConfigurator;
use App\Validator\Password\Rule\HasSmallLetter;
use PHPUnit\Framework\TestCase;

class HasSmallLetterTest extends TestCase
{
    private HasSmallLetter $rule;

    protected function setUp(): void
    {
        $configurator = $this->createMock(RuleConfigurator::class);

        $this->rule = new HasSmallLetter($configurator);
    }

    public function testIsValidWithSmalLetterShouldReturnTrue(): void
    {
        $this->assertTrue($this->rule->isValid('has_small_letter'));
    }

    public function testIsValidWithNoSmallLetterShouldReturnFalse(): void
    {
        $this->assertFalse($this->rule->isValid('HAS_NO_SMALL_LETTER'));
    }
}
