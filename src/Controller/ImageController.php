<?php

namespace App\Controller;

use App\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/img', name: 'image')]
    public function index(): Response
    {
        return $this->render('image/index.html.twig', [
            'form' => $this->createForm(ImageType::class)->createView()
        ]);
    }
}
