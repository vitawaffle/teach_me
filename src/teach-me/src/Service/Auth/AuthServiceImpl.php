<?php

namespace App\Service\Auth;

use App\Dto\SigninDto;
use App\Entity\User;
use App\Repository\{UserRepository, RoleRepository};
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthServiceImpl implements AuthService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly RoleRepository $roleRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function signin(SigninDto $signinDto): void
    {
        $user = new User(
            username: $signinDto->username,
        );

        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            $signinDto->password,
        ));

        $this->userRepository->save($user);
    }
}
