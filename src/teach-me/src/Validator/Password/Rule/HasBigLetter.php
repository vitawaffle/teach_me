<?php

namespace App\Validator\Password\Rule;

use App\Validator\Password\Configurator\RuleConfigurator;

class HasBigLetter implements Rule
{
    use ActivatedWithTrueValue;

    private string $ruleName = 'hasBigLetter';

    public function __construct(
        private readonly RuleConfigurator $configurator,
    ) {
    }

    public function isValid(string $value): bool
    {
        return preg_match('/[A-ZА-Я]/', $value);
    }
}
