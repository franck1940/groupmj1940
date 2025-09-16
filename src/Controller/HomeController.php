<?php

namespace App\Controller;


use App\services\menuservice\MenuServices;
use App\services\pgcontentservices\PageContentsServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: "app_home")]
    public function showHome(): Response
    {

        return $this->render('@frontend/home.html.twig', []);
    }

    #[Route(path: "/grpfd")]
    public function gotToHome(): Response
    {

        return $this->render('@frontend/home.html.twig', []);
    }

    // #[Route(path:'/{k}', name:"app_home")]
    // public function handledHomeReq(string $k): Response
    // {
    //    if(str_contains("login",$k))
    //    {
    //     $this->redirectToRoute("app_login");
    //     echo $k;
    //    }
    //     return $this->render('@frontend/home.html.twig', []);
    // }

    #[Route(path: '/grpfd/{routmenu}')]
    public function handelfdRouteMenu(string $routmenu, EntityManagerInterface $entityManager): Response
    {
        $menuservice = new MenuServices($entityManager);
        $retreiveRouteValue = explode("/", $routmenu);
        $len = count($retreiveRouteValue);
        echo $len;
        $name = $menuservice->findMenuByTitle($retreiveRouteValue[$len - 1]);
        echo $name[0]->getMenuRoute();

        return $this->render('@frontend/home.html.twig', []);
    }

    #[Route(path: '/group_nj_services', name: "app_services", methods: ["GET"])]
    public function groupNjService(EntityManagerInterface $entityManager): Response
    {
        $contentsServices = new PageContentsServices($entityManager);
        $menuServices = new MenuServices($entityManager);
        $services = $menuServices->findMenuByTitle("Services");
        $contents = $services[0]->getPagecontents();

        return $this->render('@frontend/groupnj_services.html.twig', ["contents"=>$contents]);

    }

    #[Route(path: 'group_nj_services/it_training', name: "app_it_training", methods: ["GET"])]
    public function groupNjService_it_training(EntityManagerInterface $entityManager): Response
    {
        return $this->render('@frontend/it_training.html.twig', []);

    }

    #[Route(path: 'group_nj_services/it_training/orm', name: "app_orm", methods: ["GET"])]
    public function groupNjService_orm(EntityManagerInterface $entityManager): Response
    {
        return $this->render('@frontend/orm.html.twig', []);

    }

    #[Route(path: 'group_nj_services/it_training/app_programming', name: "app_programming", methods: ["GET"])]
    public function groupNjService_programming(EntityManagerInterface $entityManager): Response
    {
        return $this->render('@frontend/app_programming.html.twig', []);

    }

    #[Route(path: 'group_nj_services/project_management', name: "app_projectmanagement", methods: ["GET"])]
    public function groupNjService_projectmanagement(EntityManagerInterface $entityManager): Response
    {
        return $this->render('@frontend/projectmanagement.html.twig', []);

    }


    #[Route(path: 'group_nj_services/transport', name: "app_transport", methods: ["GET"])]
    public function groupNjService_transport(EntityManagerInterface $entityManager): Response
    {
        return $this->render('@frontend/transport.html.twig', []);

    }


    #[Route(path: 'group_nj_services/farming', name: "app_farming", methods: ["GET"])]
    public function groupNjService_farming(EntityManagerInterface $entityManager): Response
    {
        return $this->render('@frontend/farming.html.twig', []);

    }




}
