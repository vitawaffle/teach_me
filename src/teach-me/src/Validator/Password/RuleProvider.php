<?php

namespace App\Validator\Password;

use App\Validator\Password\Rule\{
    Rule,
    HasBigLetter,
    HasNumber,
    HasSmallLetter,
    MinimalLength,
};
use App\Validator\Password\Configurator\RuleConfigurator;

class RuleProvider
{
    public function __construct(
        private readonly RuleConfigurator $configurator,
    ) {
    }

    /** @return Rule[] */
    public function getRules(): array
    {
        return [
            new HasBigLetter($this->configurator),
            new HasNumber($this->configurator),
            new HasSmallLetter($this->configurator),
            new MinimalLength($this->configurator),
        ];
    }
}
