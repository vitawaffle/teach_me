<?php

namespace App\Dto;

use App\Entity\User;
use App\Validator\Password\Password;
use App\Validator\Unique\Unique;
use App\Validator\Username\Username;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

class SigninDto extends Dto
{
    public function __construct(
        #[
            NotBlank,
            Username,
            Unique(entityClass: User::class, columnName: 'username')
        ]
        public readonly ?string $username = null,
        #[NotBlank, Password]
        public readonly ?string $password = null,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $requestData = self::requestContentToArray($request);

        return new SigninDto(
            username: $requestData['username'] ?? null,
            password: $requestData['password'] ?? null,
        );
    }
}
