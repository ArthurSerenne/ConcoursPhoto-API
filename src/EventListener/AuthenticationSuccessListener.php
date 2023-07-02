<?php

namespace App\EventListener;

// src/App/EventListener/AuthenticationSuccessListener.php
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $member = $user->getMember();

        if ($member) {
            $member->setLastLoginDate(new \DateTime());
            $this->entityManager->persist($member);
            $this->entityManager->flush();
        }

        $event->setData($data);
    }
}
