<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class UploadController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }


    #[Route('/uploads/images/', name: 'upload_image', methods: ['POST'])]
    public function uploadImage(Request $request): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('file');

        if ($file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->params->get('uploads_images_directory'), // get uploads_directory parameter from services
                    $newFilename
                );
            } catch (FileException $e) {
                // ... gérer l'exception si quelque chose se passe mal lors du téléchargement du fichier
            }

            // à ce stade, le fichier est téléchargé, vous pouvez donc renvoyer la réponse
            return new Response($newFilename);
        }

        return new Response("Aucun fichier sélectionné", Response::HTTP_BAD_REQUEST);

    }
}