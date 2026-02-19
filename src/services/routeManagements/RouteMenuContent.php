<?php

namespace App\services\routeManagements;

use App\Entity\Menu;
use App\Entity\Pagecontents;
use App\services\menuservice\MenuServices;
use App\services\pgcontentservices\PageContentsServices;
use DateTime;
use DateTimeZone;

class RouteMenuContent implements IRouteMenuContent
{
    private MenuServices $menu_services;
    private PageContentsServices $page_contents_services;
    public function __construct(private MenuServices $menuServices, PageContentsServices $pageContentsServices)
    {
        $this->menu_services = $menuServices;
        $this->page_contents_services = $pageContentsServices;
    }
    public function getAllContentOfMenu(string $menuTitle): array
    {
        //$checkCt = str_contains($menuTitle, "_");
        $tp = str_replace("_"," ",$menuTitle);

        $menu = $this->menu_services->findMenuByTitle($tp);

        $contents = ($menu)? $this->page_contents_services->findContentsByMenuId($menu[0]->getId()):[];
        return $contents;
    }

    public function getMenu(string $name): Menu
    {
        $menu = $this->menu_services->findMenuByTitle($name);
        return ($menu) ? $menu[0] : null;
    }

    public  function getContent(int $menuId): Pagecontents
    {
        $contents = $this->page_contents_services->findContentsByMenuId($menuId);
        return ($contents) ? $contents[0] : null;
    }
    public  function getMenuRoute(string $title): string
    {
        $menu = $this->menu_services->findMenuByTitle($title);
        return ($menu) ? $menu[0]->getMenuRoute() : "";
    }

    public  function isContentExpirated(int $contentId): bool
    {
        //date_default_timezone_set('Europe/London');
        //new DateTimeZone("Europe/Berlin")
        $contents = $this->page_contents_services->findContentsById($contentId);
        $ctDate = $contents->getExpiredDate();

        if(!$ctDate)
            return false;

        $today = new DateTime("now", new DateTimeZone("Europe/Berlin"));
        $tdYear = $today->format("y");
        $ctYear = $ctDate->format("y");
        $tdMonth = $today->format("m");
        $ctMonth = $ctDate->format("m");
        $tdDay = $today->format("d");
        $ctDay = $ctDate->format("d");

        return (($tdYear > $ctYear) || ($tdMonth > $ctMonth) || ($tdDay > $ctDay));
    }

    public  function getCententExpiratedDate(int $contentId): DateTime
    {
        $contents = $this->page_contents_services->findContentsById($contentId);

        return ($contents) ? $contents->getExpiredDate() : null;
    }

    public  function getCententCreateDate(int $contentId): DateTime
    {
        $contents = $this->page_contents_services->findContentsById($contentId);

        return ($contents) ? $contents->getCreateDate() : null;
    }
}
