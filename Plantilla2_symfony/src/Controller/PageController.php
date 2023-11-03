<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

}
