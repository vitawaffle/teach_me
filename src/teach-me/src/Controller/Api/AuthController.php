<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[Route('/auth', name: 'auth_', methods: 'POST')]
class AuthController extends AbstractController
{
    #[Route('/login', name: 'login', methods: 'POST')]
    public function login(Request $request): Response
    {
        return new Response();
    }

    #[Route('/signin', name: 'signin', methods: 'POST')]
    public function signin(Request $request): Response
    {
        return new Response();
    }
}
