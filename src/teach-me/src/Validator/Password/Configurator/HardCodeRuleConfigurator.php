<?php

namespace App\Validator\Password\Configurator;

class HardCodeRuleConfigurator implements RuleConfigurator
{
    public function getValue(string $key): mixed
    {
        return match ($key) {
            'hasBigLetter' => true,
            'hasSmallLetter' => true,
            default => null,
        };
    }
}
