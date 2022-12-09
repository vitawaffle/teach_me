<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;

abstract class Dto
{
    abstract public static function fromRequest(Request $request): self;

    protected static function requestContentToArray(Request $request): array
    {
        return json_decode($request->getContent(), true);
    }
}
