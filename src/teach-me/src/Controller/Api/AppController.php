<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class AppController extends AbstractController
{
    protected function jsonValidationErrors(ConstraintViolationListInterface $validationErrors): Response
    {
        $errorArray = [];
        foreach ($validationErrors as $error) {
            $errorArray[$error->getPropertyPath()] = $error->getMessage();
        }

        return $this->json($errorArray, Response::HTTP_BAD_REQUEST);
    }
}
