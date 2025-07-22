<?php

namespace App\Controller;

use App\Entity\Htmltemplates;
use App\Entity\Pagecontents;
use App\services\menuservice\MenuServices;
use App\services\pgcontentservices\PageContentsServices;
use App\services\templateservice\HtmlTemplateServices;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PgContentsController extends AbstractController
{
    #[Route(path: "/backendmanagement/pagecontentmanagement/pgcontentGui", name: "pgcontentGui")]
    public function createPageContents(EntityManagerInterface $entityManager, Request $request): Response
    {
        $response = $request->get("response");
        $cssResponse = $request->get("cssResponse");
        $allmenus = "";
        $selecetMenu = "";
        $menuServices = new MenuServices($entityManager);
        $htmlTplServices = new HtmlTemplateServices($entityManager);
        $allmenus = $menuServices->findAllMenus();
        $alltemplates = $htmlTplServices->findAllHtmlTemplate();
        return $this->render('@backend/createPageContents.html.twig', [
            "value" => "Create contents",
            "cssResponse" => $cssResponse,
            "response" => $response,
            "allmenus" => $allmenus,
            "selected" => $selecetMenu,
            "allTemplates" => $alltemplates

        ]);
    }

    #[Route(path: "/backendmanagement/pagecontentmanagement/insertPgContent", name: "insertPgcontent", methods: ["POST"])]
    public function insertContentsForPage(EntityManagerInterface $entityManager, Request $request): Response
    {
        $target_dir = "contentimages/";
        $response = "ERROR:Insert page content failed";
        $cssResponse = "color:red;";
        $pageTitle = $request->request->get("title");
        $image = $_FILES["picture"]["name"];
        $contents = $request->request->get("contenteditor");
        $menuId = $request->request->get("allmenu");
        $pgctServices = new PageContentsServices($entityManager);
        $menuServices = new MenuServices($entityManager);
        $pgTemplate = $request->request->get("htmlTemplates");
        $action = $request->request->get("action");

        $isContentsFilled = true;

        if (!$menuId) {
            $response = $response . "[targeted menu missing]";
            $isContentsFilled = false;
        }
        if (!$pageTitle) {
            $response = $response . "[Title missing]";
            $isContentsFilled = false;
        }
        if (!$contents) {
            $response = $response . "[Contents missing]";
            $isContentsFilled = false;
        }

        if (isset($_FILES["picture"]["name"]) && $image) {
            $target_file = $target_dir . basename($_FILES["picture"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $checkPictutre = getimagesize($_FILES["picture"]["tmp_name"]);
            if (!$checkPictutre) {
                $response = $response . "[" . "File is an image - " . $checkPictutre["mime"] . "].";
                $isContentsFilled = false;
            }
            if (file_exists($target_file)) {
                $response = $response . "[Sorry, file already exists.]";
                //  $isContentsFilled = true;
            }
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $response = $response . ":[Sorry, only JPG, JPEG, PNG & GIF files are allowed.]";
                $isContentsFilled = false;
            }
        }
        if ($isContentsFilled) {
            $pageContents = ($action) ? $pgctServices->findContentsById($action) : new Pagecontents();

            if ($image) {

                if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                    $response = $response . "The file " . htmlspecialchars(basename($_FILES["picture"]["name"])) . " has been uploaded.";
                } else {
                    $response = $response . "Sorry, there was an error uploading your file. to " . $target_file;
                }

                $filename = pathinfo($_FILES['picture']['name'], PATHINFO_FILENAME);
                $filename = $filename . "." . $imageFileType;
                $pageContents->setPicture($filename);
            }

            $menu = $menuServices->findMenuById($menuId);
            $pageContents->setMenu($menu);
            $pageContents->setTitle($pageTitle);
            $pageContents->setContentText($contents);
            $pageContents->setCreateDate(new DateTime(date("Y-m-d")));
            $htmlTplateServices = new HtmlTemplateServices($entityManager);
            $htmltpl = ($pgTemplate) ? ((empty($action)) ? $htmlTplateServices->findHtmlTemplateById($pgTemplate) : $htmlTplateServices->findHtmlTemplateByName($pgTemplate)[0]) : null;
            $result = false;
            if ($htmltpl) {
                $pageContents->setContentTemplate($htmltpl);

                $result = $pgctServices->insertPgContents($pageContents);
            } else {
                $response = $response . "[Template missing]";
                $cssResponse = "color:red";
            }

            if ($result) {
                $response = "Insert contents succcessful";
                $cssResponse = "color:green";
            }
        }


        return $this->redirectToRoute("pgcontentGui", [
            "cssResponse" => $cssResponse,
            "response" => $response
        ]);
    }

    #[Route(path: "/backendmanagement/pagecontentmanagement/contentOfaMenu", name: "contentOfaMenu", methods: ["POST"])]
    public function getAllContentOfaMenu(EntityManagerInterface $entityManager, Request $request)
    {
        $menuId = $request->request->get("id");

        $pgctServices = new PageContentsServices($entityManager);

        $rslt = [];
        if ($menuId) {
            $contents = $pgctServices->findContentsByMenuId($menuId);
            foreach ($contents as $value) {
                $menu = $value->getMenu();
                $html = $value->getContentTemplate();
                array_push($rslt, array(
                    "id" => $value->getId(),
                    "menuid" => array("id" => $menu->getId(), "title" => $menu->getTitle()),
                    "title" => $value->getTitle(),
                    "contentText" => $value->getContentText(),
                    "picture" => $value->getPicture(),
                    "createDate" => $value->getCreateDate(),
                    "templates" => array("id" => $html->getId(), "templateName" => $html->getTemplateName())
                ));
            }
        }
        $json = json_encode($rslt);
        return new Response($json, 200, []);
    }
    #[Route(path: "/backendmanagement/pagecontentmanagement/all")]
    public function showAllContents(EntityManagerInterface $entityManager)
    {
        $pgctServices = new PageContentsServices($entityManager);
        //$menuServices = new MenuServices($entityManager);
        //$contents =[];
        $cts = $pgctServices->findAllContents();
        $header = array("Menu title", "Content title", "Content text", "template", "picture");
        //  foreach ($cts as $pgct) {
        //     $arr = array($pgct->getMenu()->getTitle(), $pgct->getTitle(),

        //  }
        return $this->render('@backend/allPageContents.html.twig', ["value" => "All contents", "headers" => $header, "contents" => $cts]);
    }


    #[Route(path: "/backendmanagement/pagecontentmanagement/deleteContent", name: "deleteContent", methods: ["POST"])]
    public function deleteContent(EntityManagerInterface $entityManager, Request $request)
    {
        $ctId = $request->request->get("id");
        $pgctServices = new PageContentsServices($entityManager);
        $result = $pgctServices->deleteContentsById($ctId);
        return new Response(($result) ? "successful" : "failed", 200, []);
    }
}
