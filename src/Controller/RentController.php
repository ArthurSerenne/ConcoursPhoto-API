<?php

namespace App\Controller;

use App\Entity\AdSpace;
use App\Entity\Rent;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RentController extends AbstractController
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
                ->subject(' nouveau compte membre créé')
                ->html('Un nouveau compte membre a été créé : <br>

                    Espace de publicité : '. $entityManager->getRepository(AdSpace::class)->find(id: 1)->getName() .' <br>
                    Date de début : '. $entity1Data['start_date'] .' <br>
                    Date de fin : '. $entity1Data['end_date'] .' <br>
                    Visuel : '. $entity1Data['file'] .' <br>
                    Url : '. $entity1Data['click_url'] .' <br>
                    Remarques : '. $entity1Data['start_date'] .' <br>');

            try {
                $mailer->send($adminEmail);
            } catch (\Exception $e) {
                error_log($e->getMessage());
                return new JsonResponse(['error' => 'Mail could not be sent'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        return new JsonResponse(['message' => 'Rent Mail Sent'], JsonResponse::HTTP_CREATED);
    }

    public function update($id, Request $request, SerializerInterface $serializer): Response
    {
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return new JsonResponse(['error' => 'User not logged in token'], 401);
        }

        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return new JsonResponse(['error' => 'User not logged in user'], 401);
        }

        $rent = $this->entityManager->getRepository(Rent::class)->find($id);

        if (!$rent) {
            return new JsonResponse(['error' => 'Rent not found or access denied'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $entity1Data = $data['entity1Data'] ?? null;

        if (!isset($entity1Data)) {
            return $this->json(['error' => 'Entity1Data is missing'], 400);
        }

        try {
            $serializer->deserialize(json_encode($entity1Data), Rent::class, 'json', ['object_to_populate' => $rent]);

            if (array_key_exists('file', $entity1Data)) {
                $base64Image = $entity1Data['file'];
                if ($base64Image === null) {
                    $rent->setFile(null);
                } else {
                    $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $base64Image);
                    $data = base64_decode($base64Image);
                    $uniqueFileName = uniqid() . '.png';
                    $imagePath = $this->getParameter('uploads_images_directory') . '/' . $uniqueFileName;
                    file_put_contents($imagePath, $data);
                    $rent->setFile($uniqueFileName);
                }
            }
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Invalid data provided',
                'exceptionMessage' => $e->getMessage(),
                'exceptionTrace' => $e->getTraceAsString(),
            ], 400);
        }

        $this->entityManager->flush();

        return $this->json($user);
    }
}
