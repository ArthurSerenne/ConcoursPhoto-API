<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\SocialNetwork;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, MailerInterface $mailer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setGender($data['gender']);
        $user->setBirthdate(new \DateTime($data['birthdate']));
        $user->setCreationDate(new \DateTime());

        $member = new Member();
        $member->setUser($user);
        $member->setUsername(strtolower($user->getFirstname()) . '.' . strtolower($user->getLastname()));
        $member->setStatus(true);
        $member->setRegistrationDate(new \DateTime());
        $member->setUpdateDate(new \DateTime());
        $member->setLastLoginDate(new \DateTime());
        $member->setSituation($data['situation']);

        $socialNetwork = new SocialNetwork();
        $socialNetwork->setMember($member);

        $entityManager->persist($user);
        $entityManager->persist($member);
        $entityManager->persist($socialNetwork);
        $entityManager->flush();

        $userRepository = $entityManager->getRepository(User::class);
        $superAdmins = $userRepository->findSuperAdmins();

        foreach ($superAdmins as $admin) {
            $adminEmail = (new Email())
                ->from('noreply@concoursphoto.com')
                ->to($admin->getEmail())
                ->subject($member->getUsername() . ' : nouveau compte membre créé')
                ->html('Un nouveau compte membre a été créé : <br>

                    Pseudo : ' . $member->getUsername() . ' <br>
                    Genre : ' . $user->getGender() . ' <br>
                    Prénom : ' . $user->getFirstname() . ' <br>
                    Nom : ' . $user->getLastname() . ' <br>
                    Age : ' . $user->getBirthdate()->diff(new \DateTime())->y . ' <br>
                    Ville : ' . $user->getCity() . ' <br>

                    <a href="http://localhost:8000/admin?crudAction=detail&crudControllerFqcn=App%5CController%5CAdmin%5CUserCrudController&entityId=' . $user->getId() . '">Accéder à la fiche</a>');

                    try {
                        $mailer->send($adminEmail);
                    } catch (\Exception $e) {
                        echo $e->getMessage();
                    }
        }


        return new JsonResponse(['message' => 'User successfully registered'], JsonResponse::HTTP_CREATED);
    }
}