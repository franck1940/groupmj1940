<?php

namespace App\Controller;

use App\Entity\Menu;
use App\services\menuservice\MenuServices;
use App\services\pgcontentservices\PageContentsServices;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuManagementController extends AbstractController
{
    #[Route(path: "/backendmanagement/menumanagement/rootmenucreategui", name: "rootmenucreategui")]
    public function createRootMenu(EntityManagerInterface $entityManager, Request $request): Response
    {
        $response = $request->get("response");
        $cssResponse = $request->get("cssResponse");

        return $this->render('@backend/createRootMenu.html.twig', [
            "value" => "Create root menu",
            "cssResponse" =>  $cssResponse,
            "response" => $response
        ]);
    }

    #[Route(path: "/backendmanagement/menumanagement/docreateRtmenu", name: "docreateRtmenu", methods: ["POST"])]
    public function doCreateRootMenu(EntityManagerInterface $entityManager, Request $request): Response
    {
        $response = "ERROR: Create root menu failed";
        $cssResponse = "color:red;";
        $menuServices = new MenuServices($entityManager);
        $menuTitle = $request->request->get("rootMenuName");
        $rslt = false;
        if ($menuTitle) {
            $menu = $menuServices->findMenuByTitle($menuTitle);
            if (!$menu) {
                $routeMenu = "/" . str_replace(" ", "_", strtolower($menuTitle));

                $menu = new Menu();
                $menu->setTitle($menuTitle);
                $dt = date("Y-m-d");
                $menu->setMenuRoute($routeMenu);
                $menu->setCreateDate(new DateTime($dt));
                $rslt = $menuServices->createRootMenu($menu);
                $rslt = true;
            } else {
                $response = "ERROR: aleready exist:[" . $menuTitle . "]";
            }
        }

        if ($rslt) {
            $cssResponse = "color:green;";
            $response = "Menu create successful";
        }

        return  $this->redirectToRoute("rootmenucreategui", [
            "cssResponse" =>  $cssResponse,
            "response" => $response
        ]);
    }

    #[Route(path: "/backendmanagement/menumanagement/mgrp", name: "mgrp", methods: ["POST"])]
    public function getRootMenus(EntityManagerInterface $entityManager, Request $request): Response
    {
        $menuServices = new MenuServices($entityManager);
        $rtId = $request->request->get("rootId");
        $rootmenus = ($rtId) ? $menuServices->findSbMenu($rtId) : $menuServices->findAllRootMenu();
        $js = [];
        foreach ($rootmenus as $key) {
            array_push($js, json_encode(array("id" => $key->getId(), "title" => $key->getTitle())));
        }

        return new Response(json_encode($js));
    }



    #[Route(path: "/backendmanagement/menumanagement/creatertsbgui", name: "creatertsbgui")]
    public function ShowcreateRtSbMenuGui(EntityManagerInterface $entityManager, Request $request): Response
    {
        $response = $request->get("response");
        $cssResponse = $request->get("cssResponse");
        $menuServices = new MenuServices($entityManager);
        $rootmenus = $menuServices->findAllRootMenu();
        $rootmenuId = $request->get("selected");
        $selectedRootMenuId = $request->request->get("selectedRootMenu");

        $sbmenus = ($selectedRootMenuId) ? $menuServices->findSbMenu($selectedRootMenuId) : [];
        $selectRtMenu = ($selectedRootMenuId) ? $menuServices->findMenuById($selectedRootMenuId) : [];

        return $this->render('@backend/createRootSubMenu.html.twig', [
            "value" => "Create sub menu",
            "cssResponse" =>  $cssResponse,
            "response" => $response,
            "rootmenus" => $rootmenus,
            "selected" => $rootmenuId,
            "sbmenus" => $sbmenus,
            "selectRtMenu" => $selectRtMenu
        ]);
    }

    #[Route(path: "/backendmanagement/menumanagement/delete", name: "delete")]
    public function deleteMenuGui(EntityManagerInterface $entityManager, Request $request): Response
    {
        $response = "ERROR:Sub menu delete failed!";
        $cssResponse = "color:red;";
        $rslt = false;
        $menuServices = new MenuServices($entityManager);
        $contentservice = new PageContentsServices($entityManager);
        $mId = $request->request->get("id");

        if ($mId) {
            $m = $menuServices->findMenuById($mId);
            $sbM = $menuServices->findSbMenu($m->getId());
            $cts = $contentservice->findContentsByMenuId($m->getId());
            if ($cts) {
                foreach ($cts as $c) {
                    $entityManager->remove($c);
                }
            }
            if (!empty($sbM)) {
                foreach ($sbM as $y) {
                    $tp = $menuServices->findSbMenu($y->getId());
                    if (!empty($tp)) {
                        foreach ($tp as $k) {
                            $entityManager->remove($k);
                        }
                    }
                    $entityManager->remove($y);
                }
            }
            $entityManager->remove($m);
            $entityManager->flush();
            $rslt = true;
        }

        if ($rslt) {
            $cssResponse = "color:green;";
            $response = "Sub menu create successful";
        }

        return new Response(($rslt) ? "successful": "failed", 200, [
            "cssResponse" =>  $cssResponse,
            "response" => $response
        ]);
    }


    #[Route(path: "/backendmanagement/menumanagement/creatertsb", name: "creatertsb")]
    public function SaveRtSubMenu(EntityManagerInterface $entityManager, Request $request): Response
    {
        $response = "ERROR:Sub menu create failed!";
        $cssResponse = "color:red;";
        $rslt = false;
        $menuServices = new MenuServices($entityManager);
        $submenuTitle = $request->request->get("submenuTitle");
        $rootmenuId = $request->request->get("rootmenu");

        if ($submenuTitle) {
            $rtMenu = $menuServices->findMenuById($rootmenuId);
            $findByTitle = $menuServices->findMenuByTitle($submenuTitle);
            if (!$findByTitle)
                $rslt = $menuServices->createRootSubMenu($rtMenu, $submenuTitle);
        }

        if ($rslt) {
            $cssResponse = "color:green;";
            $response = "Sub menu create successful";
        }

        return $this->redirectToRoute("creatertsbgui", [
            "cssResponse" =>  $cssResponse,
            "response" => $response,
            "selected" => $rootmenuId
        ]);
    }

    #[Route(path: "/backendmanagement/menumanagement/createsbsbmengui", name: "createsbsbmengui")]
    public function showSubSubMenugui(EntityManagerInterface $entityManager, Request $request): Response
    {
        $response = $request->get("response");
        $cssResponse = $request->get("cssResponse");
        $menuServices = new MenuServices($entityManager);
        $rootmenus = $menuServices->findAllRootMenu();
        $rootmenuId =  $request->get("selectedRtId");
        $submenuId = $request->get("selectedSbId");
        $sbOfRootMenu = ($rootmenuId) ? $menuServices->findSbMenu($rootmenuId) : "";

        return $this->render('@backend/createSubSubMenu.html.twig', [
            "value" => "Create sub sub menu",
            "cssResponse" => $cssResponse,
            "response" => $response,
            "rootmenus" => $rootmenus,
            "selected" => $rootmenuId,
            "subselected" => $submenuId,
            "submenus" => $sbOfRootMenu
        ]);
    }

    #[Route(path: "/backendmanagement/menumanagement/createasbsbmenu", name: "createasbsbmenu")]
    public function createSubSubMenu(EntityManagerInterface $entityManager, Request $request): Response
    {
        $response = "ERROR:Sub menu create failed!";
        $cssResponse = "color:red;";
        $rslt = false;
        $menuServices = new MenuServices($entityManager);
        $sbsbmenuTitle = $request->request->get("subsubmenuTitle");
        $callrootsb = $request->request->get("callrootsb");
        $rootmenuId = $request->request->get("rootmenu");
        $submenuId = $request->request->get("submenu");


        if ($sbsbmenuTitle && !$callrootsb && $submenuId) {
            $rslt = $menuServices->createSubSubMenu($rootmenuId, $submenuId, $sbsbmenuTitle);
        }

        if ($rslt) {
            $cssResponse = "color:green;";
            $response = "Sub menu create successful";
        }

        return $this->redirectToRoute("createsbsbmengui", [
            "cssResponse" =>  $cssResponse,
            "response" => $response,
            "selectedRtId" => $rootmenuId,
            "selectedSbId" => $submenuId
        ]);
    }
    #[Route(path: "/backendmanagement/menumanagement/update", name: "update", methods: ["POST"])]
    function updateMenu(EntityManagerInterface $entityManager, Request $request): Response
    {
        $meuId = $request->request->get("id");
        $newTitle = $request->request->get("title");
        $menuServices = new MenuServices($entityManager);
        $rslt = false;

        $response = "ERROR: Update menu failed!";
        $cssResponse = "color:red;";

        if ($meuId && trim($newTitle)) {
            $menu = $menuServices->findMenuById($meuId);
            $menu->setTitle(trim($newTitle));
            if ($menu->getMenuRoute())
                $menu->setMenuRoute(strtolower($menu->getMenuRoute()));
            $entityManager->persist($menu);
            $entityManager->flush();
            $rslt = true;
        }

        if ($rslt) {
            $cssResponse = "color:green;";
            $response = "Sub menu create successful";
        }

        return new Response(($rslt) ? "successful" : "failed", 200, [
            "cssResponse" =>  $cssResponse,
            "response" => $response
        ]);
    }
}
