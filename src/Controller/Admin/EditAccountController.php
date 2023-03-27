<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use App\Form\EditAccountType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class EditAccountController extends AbstractController
{

    #[Route('/admin/edit-account', name: 'admin_edit_account')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function editAccount(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(EditAccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre compte a bien été modifié');

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edit_account.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
