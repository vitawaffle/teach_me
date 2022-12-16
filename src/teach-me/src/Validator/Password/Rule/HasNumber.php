<?php

namespace App\Validator\Password\Rule;

use App\Validator\Password\Configurator\RuleConfigurator;

class HasNumber implements Rule
{
    use ActivatedWithTrueValue;

    private string $ruleName = 'hasNumber';

    public function __construct(
        private readonly RuleConfigurator $configurator,
    ) {
    }

    public function isValid(string $value): bool
    {
        return preg_match('/[0-9]/', $value);
    }
}
