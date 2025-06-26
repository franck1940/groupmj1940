<?php
namespace App\services\pgcontentservices;
use App\Entity\Pagecontents;
use Proxies\__CG__\App\Entity\Menu;

interface IPageContentsServices{
    public function insertPgContents(Pagecontents $pgCts):bool;
    public function findContentsById(int $contentId):Pagecontents;
    public function findContentsByTitle(String $title):Pagecontents;
    public function deleteContentsById(int $contentId):bool;
    public function findContentsByMenuId(int $menu):array;
    public function deleteContentsByMenuId(int $contentId):bool;
    public function findAllContents():array;
}
?>