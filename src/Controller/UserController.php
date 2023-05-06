<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    private $tokenStorage;

    public function __construct(Security $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getUserData(): JsonResponse
    {
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return new JsonResponse(['error' => 'User not logged in'], 401);
        }

        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return new JsonResponse(['error' => 'User not logged in'], 401);
        }

        // Utilisez la méthode json() pour transformer l'objet utilisateur en une réponse JSON
        return $this->json($user);
    }
}
