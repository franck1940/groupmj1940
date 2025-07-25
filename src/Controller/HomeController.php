<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(path:'/', name:"app_home")]
    public function showHome(): Response
    {
        return $this->render('@frontend/home.html.twig', []);
    }
}
