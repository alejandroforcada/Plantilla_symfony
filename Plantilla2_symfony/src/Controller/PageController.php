<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Entity\Trabajador;
use App\Form\joinUsFormType;
use App\Form\RegistrationFormType;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;


class PageController extends AbstractController
{
    #[Route('/', name: 'inicio')]
    public function index(): Response
    {
        return $this->render('page/inicio.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('page/about.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
    #[Route('/service', name: 'service')]
    public function service(): Response
    {
        return $this->render('page/service.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
    #[Route('/team', name: 'team')]
    public function team(): Response
    {
        return $this->render('page/team.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
    #[Route('/why', name: 'why')]
    public function why(): Response
    {
        return $this->render('page/why.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
    #[Route('/join_us', name: 'join_us')]
    public function joinUs(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppCustomAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $trabajador = new Trabajador();
        $form = $this->createForm(joinUsFormType::class, $trabajador);
        $form->handleRequest($request);

      

            $entityManager->persist($trabajador);
            $entityManager->flush();
            // do anything else you need here, like send an email


        return $this->render('page/joinUs.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }
}
