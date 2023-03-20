<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    public function edit(Request $request): Response
    {
        // Obtenez l'utilisateur actuel à partir du contexte de sécurité
        $user = $this->getUser();

        // Trouvez l'entité utilisateur correspondante dans le gestionnaire d'entités Doctrine
        $entityManager = $this->getDoctrine()->getManager();
        $userEntity = $entityManager->getRepository(User::class)->find($user->getId());

        // Créez le formulaire à partir de la classe de formulaire et passez-lui l'entité utilisateur comme données initiales
        $form = $this->createForm(LoginType::class, $userEntity);

        // Traitez le formulaire soumis en validant les données, en mettant à jour l'entité utilisateur et en l'enregistrant dans la base de données
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Mettez à jour l'entité utilisateur avec les données du formulaire
            $userEntity = $form->getData();

            // Enregistrez l'entité utilisateur dans la base de données
            $entityManager->persist($userEntity);
            $entityManager->flush();

            // Redirigez vers une autre page ou affichez un message de succès
            return new Response('Utilisateur modifié avec succès');
        }

        // Renvoyez le formulaire à un modèle pour le rendre dans la vue
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
