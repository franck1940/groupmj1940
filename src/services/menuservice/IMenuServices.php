<?php
namespace App\services\menuservice;
use App\Entity\Menu;
interface IMenuServices{
    public function createRootMenu(Menu $menu):bool;
    public function createRootSubMenu(Menu $menu, string $sbmenuTitle):bool;
    public function createSubSubMenu(int $rootId, int $subId, string $sbsbmenuTitle):bool;
    public function findMenuById(int $id):Menu;
    public function findAllRootMenu():array;
    public function findSbMenu(int $id):array;
    public function deleteMenu(int $menuId):bool;
    public function findAllMenus():array;
    public function findMenuByTitle(string $title);
}
?>