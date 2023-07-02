<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Entity\SocialNetwork;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OrganizationController extends AbstractController
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

    public function create(Request $request, SerializerInterface $serializer): Response
    {
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return new JsonResponse(['error' => 'User not logged in token'], 401);
        }

        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return new JsonResponse(['error' => 'User not logged in user'], 401);
        }

        $organization = new Organization();

        $data = json_decode($request->getContent(), true);

        $entity1Data = $data['entity1Data'] ?? null;
        $entity2Data = $data['entity2Data'] ?? null;

        if (!isset($entity1Data) && !isset($entity2Data)) {
            return $this->json(['error' => 'Both entity1Data and entity2Data are missing'], 400);
        } elseif (!isset($entity1Data)) {
            return $this->json(['error' => 'entity1Data is missing'], 400);
        } elseif (!isset($entity2Data)) {
            return $this->json(['error' => 'entity2Data is missing'], 400);
        }

        try {
            $serializer->deserialize(json_encode($entity1Data), Organization::class, 'json', ['object_to_populate' => $organization]);

            if (array_key_exists('logo', $entity1Data)) {
                $base64Image = $entity1Data['logo'];
                if (null === $base64Image) {
                    $organization->setLogo(null);
                } else {
                    $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $base64Image);
                    $data = base64_decode($base64Image);
                    $uniqueFileName = uniqid().'.png';
                    $imagePath = $this->getParameter('uploads_images_directory').'/'.$uniqueFileName;
                    file_put_contents($imagePath, $data);
                    $organization->setLogo($uniqueFileName);
                }
            }

            $socialNetwork = $organization->getSocialNetwork();

            if (!$socialNetwork) {
                $socialNetwork = new SocialNetwork();
                $organization->setSocialNetwork($socialNetwork);
                $this->entityManager->persist($socialNetwork);
            }

            $organization->setUpdateDate(new \DateTime());

            $serializer->deserialize(json_encode($entity2Data), SocialNetwork::class, 'json', ['object_to_populate' => $socialNetwork]);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Invalid data provided',
                'exceptionMessage' => $e->getMessage(),
                'exceptionTrace' => $e->getTraceAsString(),
            ], 400);
        }

        $user->addOrganization($organization);

        $this->entityManager->flush();

        return $this->json($user);
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

        $organization = $this->entityManager->getRepository(Organization::class)->find($id);

        if (!$organization || !$user->getOrganizations()->contains($organization)) {
            return new JsonResponse(['error' => 'Organization not found or access denied'], 404);
        }

        if (!$organization) {
            $organization = new Organization();
            $user->addOrganization($organization);
            $this->entityManager->persist($organization);
        }

        $data = json_decode($request->getContent(), true);

        $entity1Data = $data['entity1Data'] ?? null;
        $entity2Data = $data['entity2Data'] ?? null;

        if (!isset($entity1Data) && !isset($entity2Data)) {
            return $this->json(['error' => 'Both entity1Data and entity2Data are missing'], 400);
        } elseif (!isset($entity1Data)) {
            return $this->json(['error' => 'entity1Data is missing'], 400);
        } elseif (!isset($entity2Data)) {
            return $this->json(['error' => 'entity2Data is missing'], 400);
        }

        try {
            $serializer->deserialize(json_encode($entity1Data), Organization::class, 'json', ['object_to_populate' => $organization]);

            if (array_key_exists('logo', $entity1Data)) {
                $base64Image = $entity1Data['logo'];
                if (null === $base64Image) {
                    $organization->setLogo(null);
                } else {
                    $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $base64Image);
                    $data = base64_decode($base64Image);
                    $uniqueFileName = uniqid().'.png';
                    $imagePath = $this->getParameter('uploads_images_directory').'/'.$uniqueFileName;
                    file_put_contents($imagePath, $data);
                    $organization->setLogo($uniqueFileName);
                }
            }

            $socialNetwork = $organization->getSocialNetwork();

            if (!$socialNetwork) {
                $socialNetwork = new SocialNetwork();
                $organization->setSocialNetwork($socialNetwork);
                $this->entityManager->persist($socialNetwork);
            }

            $organization->setUpdateDate(new \DateTime());

            $serializer->deserialize(json_encode($entity2Data), SocialNetwork::class, 'json', ['object_to_populate' => $socialNetwork]);
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
