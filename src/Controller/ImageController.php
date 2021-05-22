<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use App\Service\TokenService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ImageController extends AbstractController
{
    #[Route('/img', name: 'image', methods: ['GET'])]
    public function index(): Response
    {
        $form = $this->createForm(ImageType::class);

        return $this->render('image/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/img', name: 'imageUpload', methods: ['POST'])]
    public function uploadImage(
        Request $request,
        ImageRepository $imageRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $form = $this->createForm(ImageType::class);
        $form->handleRequest($request);
        if (!$form->isValid()) {
            $this->addFlash('error','Your image is invalid.  Please use another image');

            return $this->forward('App\Controller\ImageController::index');
        }

            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();
            $token = TokenService::getUniqueToken($imageRepository);
        try {
            [$width, $height] = getimagesize((string)$image->getRealPath());
            $fileName = $token . '.' . $image->guessExtension();
            $imageEntity = (new Image())
                ->setHeight($height)
                ->setWidth($width)
                ->setWeight($image->getSize())
                ->setMime($image->getMimeType() ?? '')
                ->setFilename($fileName)
                ->setToken($token);

            $image->move(
                (string)$this->getParameter('image_directory'),
                $fileName
            );

            $entityManager->persist($imageEntity);
            $entityManager->flush();

            $url = $this->generateUrl(
                'get_image',
                ['token' => $imageEntity->getToken()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $this->addFlash('success', 'Congratulations, your image is uploaded');

            return $this->render('image/image.html.twig', ['image' => $url]);
        } catch (FileException $e) {
            $this->addFlash('error', 'Unable to upload your picture.  Please try again');

            return $this->forward('App\Controller\ImageController::index');
        }
    }

    #[Route('/image/{token}', name: 'get_image')]
    public function getLink(
        string $token,
        ImageRepository $imageRepository,
        EntityManagerInterface $entityManager
    ): RedirectResponse|Response
    {
        $image = $imageRepository->findOneBy(['token' => $token]);

        if (!$image || $image->getToken() === null) {
            $this->addFlash('danger', 'Invalid link');

            return $this->forward('App\Controller\IndexController::index');
        }

        $image->setClicked();

        $entityManager->flush();

        return new BinaryFileResponse((string)$this->getParameter('image_directory') . '/' . $image->getFileName());
    }
}
