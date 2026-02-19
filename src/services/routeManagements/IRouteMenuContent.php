<?php

namespace App\services\routeManagements;

use App\Entity\Menu;
use App\Entity\Pagecontents;
use DateTime;

interface IRouteMenuContent
{
  public  function getAllContentOfMenu(string $menuTitle): array;
  public function getMenu(string $title): Menu;
  public function getContent(int $menuId):Pagecontents;
  public function getMenuRoute(string $title): string;
  public function isContentExpirated(int $contentId): bool;
  public function getCententExpiratedDate(int $contentId): DateTime;
  public function getCententCreateDate(int $contentId): DateTime;
}
