<?php

namespace App\Validator\Password\Rule;

interface Rule
{
    public function isActive(): bool;
    public function isValid(string $value): bool;
}
