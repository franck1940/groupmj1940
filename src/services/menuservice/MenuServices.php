<?php

namespace App\services\menuservice;

use App\Entity\Menu;
use App\services\menuservice\IMenuServices;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class MenuServices implements IMenuServices
{
    private EntityManager $entitymanager;
    public function __construct(private EntityManagerInterface $em)
    {
        $this->entitymanager = $em;
    }

    public function createRootMenu(Menu $menu): bool
    {
        try {

            $this->entitymanager->persist($menu);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }

        return true;
    }

    public function createRootSubMenu(Menu $rootmenu, string $sbmenuTitle): bool
    {
        try {

            if (!$rootmenu) {
                throw new Exception("createRootSubMenu: rootmenu empty");
            }
            $menuRoute =$rootmenu->getMenuRoute()."/".str_replace(" ","_",$sbmenuTitle);

            $submenu = new Menu();
            $submenu->setParentId($rootmenu->getId());
            $submenu->setTitle($sbmenuTitle);
            $dt = date("Y-m-d");
            $submenu->setCreateDate(new DateTime($dt));
            $submenu->setMenuRoute($menuRoute);
            $this->entitymanager->persist($submenu);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }

        return true;
    }

    public function createSubSubMenu(int $rootId, int $subId, string $sbsbmenuTitle): bool
    {
        try {

            $submenu = $this->findMenuById($subId);

            if (!$submenu) {
                throw new Exception("createSubSubMenu: submenu not exist");
            }

            if (empty($submenu->getParentId())) {
                throw new Exception("createSubSubMenu: submenu is root menu");
            }
            $subMenuRoute=$submenu->getMenuRoute()."/". str_replace(" ","_",$sbsbmenuTitle);

            $sbsbmenu = new Menu();
            $sbsbmenu->setParentId($subId);
            $sbsbmenu->setTitle($sbsbmenuTitle);
            $dt = date("Y-m-d");
            $sbsbmenu->setMenuRoute($subMenuRoute);
            $sbsbmenu->setCreateDate(new DateTime($dt));
            $this->entitymanager->persist($sbsbmenu);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }

        return true;
    }

    public function findMenuById(int $id): Menu
    {
        return $this->entitymanager->getRepository(Menu::class)->find($id);
    }

    public function findAllRootMenu(): array
    {
        $query = $this->entitymanager->createQuery("select m from App\Entity\Menu m where m.parentId is null or m.parentId = -1");
        //createQueryBuilder(Menu::class)->where("parent_id IS NULL")->getQuery();
        return  $query->getResult();
    }
    public function findAllMenus(): array
    {
        return $this->entitymanager->getRepository(Menu::class)->findAll();
    }

    public function findSbMenu(int $sbId): array
    {
        return $this->entitymanager->getRepository(Menu::class)->findBy(["parentId" => $sbId]);
    }
    public function findMenuByTitle(string $title){
         return $this->entitymanager->getRepository(Menu::class)->findBy(["title" => $title]);
    }

    public function deleteMenu(int $menuId): bool
    {
        // $menu= $this->findMenuById($menuId);
        //$contentService = new Conten
        return false;
    }
}
