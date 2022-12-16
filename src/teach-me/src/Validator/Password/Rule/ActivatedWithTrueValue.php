<?php

namespace App\Validator\Password\Rule;

trait ActivatedWithTrueValue
{
    public function isActive(): bool
    {
        $value = $this->configurator->getValue($this->ruleName);

        return null !== $value && (
            true === $value
                || 1 === $value
                || 'true' === strtolower($value)
                || '1' === $value
                || 'y' === strtolower($value)
                || 'yes' === strtolower($value)
        );
    }
}
