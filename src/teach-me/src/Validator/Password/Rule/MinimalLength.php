<?php

namespace App\Validator\Password\Rule;

use App\Validator\Password\Configurator\RuleConfigurator;

class MinimalLength implements Rule
{
    private const RULE_NAME = 'minimalLength';

    public function __construct(
        private readonly RuleConfigurator $configurator,
    ) {
    }

    public function isActive(): bool
    {
        return $this->configurator->getValue(self::RULE_NAME) !== null;
    }

    public function isValid(string $value): bool
    {
        return strlen($value) >= $this->configurator->getValue(self::RULE_NAME);
    }
}
