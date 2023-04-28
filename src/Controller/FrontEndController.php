<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontEndController extends AbstractController
{
    //#[Route('/test', name: 'app_frontend_dashboard')]
    #[Route('/dashboard', name: 'app_frontend_dashboard')]
    public function index() :Response
    {
        // return $this->render('dashboard.html.twig');
        return $this->render('base.html.twig');
    }
    #[Route('/dashboard-guest', name: 'app_frontend_guest')]
    public function indexGuest() :Response
    {
        // return $this->render('dashboard.html.twig');
        return $this->render('guest.html.twig');
    }

    #[Route('/test', name: 'app_test')]
    public function indexTest() :Response
    {
        // return $this->render('dashboard.html.twig');
        return $this->render('base.html.twig');
    }
}