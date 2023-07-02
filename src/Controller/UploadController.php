<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    #[Route(path: '/uploads/images/', name: 'upload_image', methods: ['POST'])]
    public function uploadImage(Request $request): Response
    {
        $uploadedFile = $request->files->get('image');

        if ($uploadedFile) {
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

            try {
                $uploadedFile->move(
                    $this->getParameter('uploads_images_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
                return new Response('File upload failed', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // Renvoie le nom du fichier modifié dans la réponse
            return new JsonResponse(['newFilename' => $newFilename], Response::HTTP_OK);
        }

        return new Response('No file provided', Response::HTTP_BAD_REQUEST);
    }

    #[Route(path: '/uploads/images/', name: 'delete_image', methods: ['DELETE'])]
    public function deleteImage(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $filename = $data['filename'];

        if ($filename) {
            $filesystem = new Filesystem();

            $file_path = $this->getParameter('uploads_images_directory').'/'.$filename;
            if ($filesystem->exists($file_path)) {
                $filesystem->remove($file_path);

                return new Response('File deleted successfully', Response::HTTP_OK);
            } else {
                return new Response('File not found', Response::HTTP_NOT_FOUND);
            }
        }

        return new Response('No filename provided', Response::HTTP_BAD_REQUEST);
    }
}
