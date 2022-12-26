<?php

namespace App\Controller\Api;

use App\Dto\SigninDto;
use App\Service\Auth\AuthService;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/auth', name: 'auth_', methods: 'POST')]
class AuthController extends AppController
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly ValidatorInterface $validator,
    ) {
    }

    #[Route('/login', name: 'login', methods: 'POST')]
    public function login(): Response
    {
        return new Response('Invalid login request', Response::HTTP_BAD_REQUEST);
    }

    #[Route('/signin', name: 'signin', methods: 'POST')]
    public function signin(Request $request): Response
    {
        $signinDto = SigninDto::fromRequest($request);

        $errors = $this->validator->validate($signinDto);
        if (count($errors) > 0) {
            return $this->jsonValidationErrors($errors);
        }

        $this->authService->signin($signinDto);

        return new Response();
    }
}
