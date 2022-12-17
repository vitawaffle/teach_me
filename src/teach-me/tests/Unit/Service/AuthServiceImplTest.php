<?php

namespace App\Unit\Service;

use App\Dto\SigninDto;
use App\Entity\User;
use App\Service\Auth\AuthServiceImpl;
use App\Repository\{UserRepository, RoleRepository};
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthServiceImplTest extends TestCase
{
    private AuthServiceImpl $service;
    private ?User $user;

    public function setUp(): void
    {
        $userRepository = $this->createMock(UserRepository::class);

        $userRepository->expects($this->any())
            ->method('save')
            ->willReturnCallback(function ($user) {
                $this->user = $user;
            });

        $roleRepository = $this->createMock(RoleRepository::class);

        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);

        $this->service = new AuthServiceImpl(
            $userRepository,
            $roleRepository,
            $passwordHasher,
        );
    }

    public function testSigninShouldSaveUser(): void
    {
        $this->service->signin(new SigninDto(
            username: 'test_user',
            password: 'secret',
        ));

        $this->assertNotNull($this->user);
    }
}
