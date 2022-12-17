<?php

namespace App\Service\Auth;

use App\Dto\SigninDto;
use App\Service\AppService;

interface AuthService extends AppService
{
    public function signin(SigninDto $signinDto): void;
}
