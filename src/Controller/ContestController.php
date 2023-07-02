<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ContestController extends AbstractController
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

    public function create(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, MailerInterface $mailer): JsonResponse
    {
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return new JsonResponse(['error' => 'User not logged in token'], 401);
        }

        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return new JsonResponse(['error' => 'User not logged in user'], 401);
        }

        $userRepository = $entityManager->getRepository(User::class);
        $superAdmins = $userRepository->findSuperAdmins();

        $data = json_decode($request->getContent(), true);

        $entity1Data = $data['entity1Data'] ?? null;

        if (!isset($entity1Data)) {
            return $this->json(['error' => 'Entity1Data is missing'], 400);
        }

        foreach ($superAdmins as $admin) {
            $adminEmail = (new Email())
                ->from('noreply@concoursphoto.com')
                ->to($admin->getEmail())
                ->subject('Demande de création d\'un concours')
                ->html(
                    '<p>Demande réalisé par '. $entity1Data['organization'] .' :</p>' .
                    '<p>Quelle est l’étendue/zone de visibilité du concours ? : ' . $entity1Data['zone'] . '</p>' .
                    '<p>Nombre de prix à gagner : ' . $entity1Data['prices'] . '</p>' .
                    '<p>Nombre de sponsors : ' . $entity1Data['sponsors'] . '</p>' .
                    '<p>Valeur total dotation/prix à gagner : ' . $entity1Data['total'] . '</p>' .
                    '<p>Thème(s) et nature du concours : ' . $entity1Data['theme'] . '</p>'
                );

            try {
                $mailer->send($adminEmail);
            } catch (\Exception $e) {
                error_log($e->getMessage());
                return new JsonResponse(['error' => 'Mail could not be sent'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        return new JsonResponse(['message' => 'Rent Mail Sent'], JsonResponse::HTTP_CREATED);
    }
}
