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
            $adSpaceName = $entityManager->getRepository(AdSpace::class)->find(id: $entity1Data['name']['value'])->getName();
            $imageUrl = $entity1Data['file'];
            $adminEmail = (new Email())
                ->from('noreply@concoursphoto.com')
                ->to($admin->getEmail())
                ->subject('Demande de location d\'un espace publicitaire')
                ->html(
                    '<p>Demande réalisé par '.$entity1Data['organization'].' :</p>'.
                    '<p>Espace de publicité : '.$adSpaceName.'</p>'.
                    '<p>Date de début : '.$entity1Data['start'].'</p>'.
                    '<p>Date de fin : '.$entity1Data['end'].'</p>'.
                    '<p>Visuel : <img src="'.$imageUrl.'"/></p>'.
                    '<p>Url : '.$entity1Data['click_url'].'</p>'.
                    '<p>Remarques : '.$entity1Data['suggest'].'</p>'
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
            $rent->setAdSpace($this->entityManager->getRepository(AdSpace::class)->find($entity1Data['name']['value']));
            $rent->setClickUrl($entity1Data['click_url']);
            $rent->setStartDate(\DateTime::createFromFormat('Y-m-d', $entity1Data['start']));
            $rent->setEndDate(\DateTime::createFromFormat('Y-m-d', $entity1Data['end']));

            if (array_key_exists('file', $entity1Data)) {
                $base64Image = $entity1Data['file'];
                if (null === $base64Image) {
                    $rent->setFile(null);
                } else {
                    $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $base64Image);
                    $data = base64_decode($base64Image);
                    $uniqueFileName = uniqid().'.png';
                    $imagePath = $this->getParameter('uploads_images_directory').'/'.$uniqueFileName;
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
