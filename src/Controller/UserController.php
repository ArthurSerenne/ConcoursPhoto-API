<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    private $tokenStorage;
    private $userRepository;
    private $entityManager;

    public function __construct(Security $tokenStorage, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
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

        return $this->json($user);
    }

    public function updateUser(Request $request, int $id): Response
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return new Response('User not found', Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        // Update user properties here, e.g., $user->setFirstname($data['firstname']);
        // ...

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new Response('User updated successfully', Response::HTTP_OK);
    }
}
