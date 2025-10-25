<?php

namespace App\utils;

use App\services\menuservice\MenuServices;
use App\services\pgcontentservices\PageContentsServices;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class DataUtils
{
    private EntityManager $entitymanager;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->entitymanager = $em;
    }
    public function getStructuredMenus()
    {
        $menuServices = new MenuServices($this->entitymanager);
        $allMenus = $menuServices->findAllMenus();
        $rslt = [];
        foreach ($allMenus as $element) {
            $sub = $menuServices->findSbMenu($element->getId());
            if (!empty($sub) && ($element->getParentId() == -1 || empty($element->getParentId()))) {
                $tp = array();
                array_push($tp, $element);
                array_push($tp, $sub);
                array_push($rslt, $tp);
            }

            if (empty($sub) && $element->getParentId() == -1) {
                array_push($rslt, $element);
            }
        }

        return $rslt;
    } #

    public function getContentsWithTheirMenus()
    {
        $contentsService = new PageContentsServices($this->entitymanager);
        $menuServices = new MenuServices($this->entitymanager);
        $allMenus = $menuServices->findAllMenus();
        $mainArray = [];

        foreach ($allMenus as $menuElement) {
            $temp1 = array();

            array_push($temp1, $menuElement);
            $pageCts = $contentsService->findContentsByMenuId($menuElement->getId());

            if ($pageCts) {
                array_push($temp1, $pageCts);
            } else {
                array_push($temp1,array());
            }

            array_push($mainArray, $temp1);
        }

        return $mainArray;
    }
}
