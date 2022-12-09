<?php

namespace App\Validator\Unique;

use App\Validator\AppConstraint;
use Attribute;
use Symfony\Component\Validator\Attribute\HasNamedArguments;

#[Attribute]
class Unique extends AppConstraint
{
    #[HasNamedArguments]
    public function __construct(
        public readonly string $entityClass,
        public readonly string $columnName,
        public readonly string $message = 'The value {{ string }} must be unique',
    ) {
        parent::__construct();
    }
}
