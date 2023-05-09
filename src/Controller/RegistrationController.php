<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\SocialNetwork;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate data here (e.g., using Symfony's Validator component)

        // Create a new user and set its properties with the form data
        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setBirthdate(new \DateTime($data['birthdate']));
        // Set other user properties (firstname, lastname, etc.)

        $member = new Member();
        $member->setUser($user);
        $member->setRegistrationDate(new \DateTime());
        $member->setLastLoginDate(new \DateTime());
        $member->setSituation($data['situation']);

        $socialNetwork = new SocialNetwork();
        $socialNetwork->setMember($member);

        $entityManager->persist($user);
        $entityManager->persist($member);
        $entityManager->persist($socialNetwork);
        $entityManager->flush();

        return new JsonResponse(['message' => 'User successfully registered'], JsonResponse::HTTP_CREATED);
    }
}