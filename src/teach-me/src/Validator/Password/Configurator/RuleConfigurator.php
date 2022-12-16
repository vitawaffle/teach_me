<?php

namespace App\Validator\Password\Configurator;

interface RuleConfigurator
{
    public function getValue(string $key): mixed;
}
