<?php

namespace App\Controller;

use App\Tax\Calculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    #[Route('/',
        name: 'app_main',
        methods: ['GET'],
        priority: 1
    )]
    public function index(): \Symfony\Component\HttpFoundation\Response
    {

       return $this ->render('home.html.twig');

    }

    #[Route('/contact',
        name: 'app_contact',
        methods: ['GET'],
        priority: 2
    )]
    public function contact(): \Symfony\Component\HttpFoundation\Response
    {
       return $this ->render('contact.html.twig');

    }

    #[Route('/about',
        name: 'app_about',
        methods: ['GET'],
        priority: 3
    )]
    public function about(): \Symfony\Component\HttpFoundation\Response
    {
       return $this ->render('about.html.twig');

    }


}


