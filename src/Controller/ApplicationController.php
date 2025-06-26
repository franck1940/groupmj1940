<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApplicationController extends AbstractController
{
    #[Route('/lucky/number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        //return $this->render('@frontend/home.html.twig',['value'=>$number]);
        return $this->render('@frontend/TextLftImgRgt.html.twig',['value'=>$number]);
        
    }
}