<?php

namespace App\Validator\Unique\Exception;

use Exception;

class InvalidColumnNameException extends Exception
{
    public function __construct(string $entityClass, string $columnName)
    {
        parent::__construct(
            "There is no column name '$columnName' in entity '$entityClass'",
        );
    }
}
