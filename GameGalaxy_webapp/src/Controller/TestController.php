<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/home', name: 'app_testfront')]
    public function indexFRONT(): Response
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    #[Route('/testback', name: 'app_testback')]
    public function indexBACK(): Response
    {
        return $this->render('BACK/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
