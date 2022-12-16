<?php

namespace App\Validator\Password\Rule;

use App\Validator\Password\Configurator\RuleConfigurator;

class HasSmallLetter implements Rule
{
    use ActivatedWithTrueValue;

    private string $ruleName = 'hasSmallLetter';

    public function __construct(
        private readonly RuleConfigurator $configurator,
    ) {
    }

    public function isValid(string $value): bool
    {
        return preg_match('/[a-zа-я]/', $value);
    }
}
