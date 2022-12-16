<?php

namespace App\Validator\Password;

use App\Validator\AppConstraint;
use Attribute;
use Symfony\Component\Validator\Attribute\HasNamedArguments;

#[Attribute]
class Password extends AppConstraint
{
    #[HasNamedArguments]
    public function __construct(
        public readonly string $message = 'Password {{ string }} has invalid format',
    ) {
        parent::__construct();
    }
}
