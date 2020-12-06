<?php

namespace App\Controller;

use App\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/img', name: 'image', methods: ['POST', 'GET'])]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ImageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $image = $form->get('image')->getData();
            dump($image);
        }

        return $this->render('image/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
