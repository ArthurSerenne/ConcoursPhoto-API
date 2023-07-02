<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\SocialNetwork;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

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

    public function update(Request $request, SerializerInterface $serializer): Response
    {
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return new JsonResponse(['error' => 'User not logged in token'], 401);
        }

        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return new JsonResponse(['error' => 'User not logged in user'], 401);
        }

        $data = json_decode($request->getContent(), true);

        $entity1Data = $data['entity1Data'] ?? null;
        $entity2Data = $data['entity2Data'] ?? null;
        $entity3Data = $data['entity3Data'] ?? null;

        if (!isset($entity1Data) || !isset($entity2Data) || !isset($entity3Data)) {
            return $this->json(['error' => 'Missing entity data'], 400);
        }

        try {
            $serializer->deserialize(json_encode($entity1Data), User::class, 'json', ['object_to_populate' => $user]);

            if (isset($entity1Data['password'])) {
                $hashedPassword = password_hash($entity1Data['password'], PASSWORD_DEFAULT);
                $user->setPassword($hashedPassword);
            }

            $member = $user->getMember();

            if (!$member) {
                $member = new Member();
                $user->setMember($member);
            }

            $serializer->deserialize(json_encode($entity2Data), Member::class, 'json', ['object_to_populate' => $member]);

            if (array_key_exists('photo', $entity1Data)) {
                $base64Image = $entity1Data['photo'];
                if (null === $base64Image) {
                    $member->setPhoto(null);
                } elseif ($base64Image !== $member->getPhoto()) {
                    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
                    $uniqueFileName = uniqid().'.png';
                    $imagePath = $this->getParameter('uploads_images_directory').'/'.$uniqueFileName;
                    file_put_contents($imagePath, $data);
                    $member->setPhoto($uniqueFileName);
                }
            }

            $socialNetwork = $member->getSocialNetwork();

            if (!$socialNetwork) {
                $socialNetwork = new SocialNetwork();
                $socialNetwork->setMember($member);
            }

            $member->setUpdateDate(new \DateTime());

            $serializer->deserialize(json_encode($entity3Data), SocialNetwork::class, 'json', ['object_to_populate' => $socialNetwork]);
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
