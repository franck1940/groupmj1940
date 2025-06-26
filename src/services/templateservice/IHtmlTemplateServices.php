<?php
namespace App\services\templateservice;

use App\Entity\Htmltemplates;

interface IHtmlTemplateServices{
    public function insertNewHtmltTemplate(Htmltemplates $htmlTp):bool;
    public function deleteAHtmltemplate(int $tId):bool;
    public function findAllHtmlTemplate():array;
    public function findHtmlTemplateById($tId):Htmltemplates;
    public function findHtmlTemplateByName($tName):array;
}
?>