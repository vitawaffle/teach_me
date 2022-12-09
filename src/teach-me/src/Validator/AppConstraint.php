<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class AppConstraint extends Constraint
{
    public function validatedBy(): string
    {
        return static::class . 'Validator';
    }
}
