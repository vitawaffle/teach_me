<?php

namespace App\Validator\Username;

use App\Validator\AppConstraint;
use Attribute;
use Symfony\Component\Validator\Attribute\HasNamedArguments;

#[Attribute]
class Username extends AppConstraint
{
    #[HasNamedArguments]
    public function __construct(
        public readonly string $message = 'Username {{ string }} has invalid format',
    ) {
        parent::__construct();
    }
}
