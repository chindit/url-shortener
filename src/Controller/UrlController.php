<?php

namespace App\Controller;

use App\Entity\Link;
use App\Entity\User;
use App\Form\LinkType;
use App\Repository\LinkRepository;
use App\Service\TokenService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UrlController extends AbstractController
{
    #[Route('/', name: 'index', host: 'url.424.fr')]
    public function index(?string $error = null): Response
    {
        return $this->render('index.html.twig', ['form' => $this->createForm(LinkType::class)->createView(), 'error' => $error]);
    }

    #[Route('/create', name:'create_link', methods:["POST"], host: 'url.424.fr')]
    public function createLink(Request $request, TokenService $tokenService, ?UserInterface $user, EntityManagerInterface $entityManager): Response
    {
        $link = new Link();
        $linkForm = $this->createForm(LinkType::class, $link);
        $linkForm->handleRequest($request);

        if ($linkForm->isSubmitted() && $linkForm->isValid())
        {
            if ($user instanceof User) {
                $link->setUser($user);
            }
            $link->setToken($tokenService->getUniqueToken());

            $entityManager->persist($link);
            $entityManager->flush();

            $url = $this->generateUrl('get_link', ['token' => $link->getToken()], UrlGeneratorInterface::ABSOLUTE_URL);
            $this->addFlash('success', 'Your link is <a id="link" href="' . $url . '">' . $url . '</a>');

        } else {
            $error = $linkForm->get('target')->getErrors()->current()->getMessage();
        }
        return $this->forward('App\Controller\IndexController::index', ['error' => $error ?? null]);
    }

    #[Route('/{token}', name: 'get_link', host: 'url.424.fr')]
    public function getLink(string $token, LinkRepository $linkRepository, EntityManagerInterface $entityManager)
    {
        $link = $linkRepository->findOneBy(['token' => $token]);

        if (!$link) {
            $this->addFlash('danger', 'Invalid link');

            return $this->forward('App\Controller\IndexController::index', ['error' => $error ?? null]);
        }

        $link->setClicked();

        $entityManager->flush();

        return $this->redirect($link->getTarget());
    }
}
