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
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;


class PageController extends AbstractController
{
    #[Route('/', name: 'inicio')]
    public function index(ManagerRegistry $doctrine ):Response
    {
        $repositorio=$doctrine->getRepository(Trabajador::class);
            $trabajadores=$repositorio->findAll();
            return $this -> render ('page/inicio.html.twig', [
                'trabajadores' => $trabajadores
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
        public function team(ManagerRegistry $doctrine ):Response
        {
            $repositorio=$doctrine->getRepository(Trabajador::class);
                $trabajadores=$repositorio->findAll();
                return $this -> render ('page/team.html.twig', [
                    'trabajadores' => $trabajadores
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
    public function joinUs(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppCustomAuthenticator $authenticator, EntityManagerInterface $entityManager, SessionInterface $session, SluggerInterface $slugger): Response
    {
        $trabajador = new Trabajador();
        $formulario = $this->createForm(joinUsFormType::class, $trabajador);
        $formulario->handleRequest($request);
        

        if($formulario->isSubmitted()&& $formulario->isValid()){
                $trabajador=$formulario->getData();
                $file = $formulario->get('foto')->getData();
                if ($file) {
                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                    // Move the file to the directory where images are stored
                    try {

                        $file->move(
                            $this->getParameter('images_directory'), $newFilename
                        );                      
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                        return new Response($e->getMessage());
                    }

                    // updates the 'file$filename' property to store the PDF file name
                    // instead of its contents
                    $trabajador->setFoto($newFilename);
                }

            $entityManager->persist($trabajador);
            $entityManager->flush();
            // do anything else you need here, like send an email
            }

        return $this->render('page/joinUs.html.twig', [
            'formulario' => $formulario->createView(),
        ]);
    }
}
