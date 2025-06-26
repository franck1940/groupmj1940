<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginUserController extends AbstractController
{
    #[Route("/backendmanagement/loginuser")]
    public function showLoginUserGui(Request $request, EntityManagerInterface $entityManager):Response
    {

        return $this->render('@backend/insertLoginUser.html.twig', ["value" => "Insert  user credentials"]);
    }

    #[Route("/backendmanagement/loginuser/insert", methods: ['POST'])]
    public function insertNewLoginUser(Request $request, EntityManagerInterface $entityManager):Response
    {

        return $this->render('@backend/insertLoginUser.html.twig', ["value" => "Insert  user credentials"]);
    }

    #[Route("/backendmanagement/loginuser/update", methods: ['POST'])]
    public function updateLoginUser(Request $request, EntityManagerInterface $entityManager):Response
    {

        return $this->render('@backend/updateLoginUser.html.twig', ["value" => "Update login credentials"]);
    }

    #[Route("/backendmanagement/loginuser/all", methods: ['POST'])]
    public function showAllLoginUser(Request $request, EntityManagerInterface $entityManager):Response
    {

        return $this->render('@backend/updateLoginUser.html.twig', ["value" => "Update login credentials"]);
    }

}

?>