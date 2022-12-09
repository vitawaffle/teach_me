<?php

namespace App\Dto;

use App\Validator\Username\Username;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

class SigninDto extends Dto
{
    public function __construct(
        #[NotBlank, Username]
        public readonly ?string $username = null,
        #[NotBlank]
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
