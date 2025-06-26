<?php

namespace App\Controller;

use App\Entity\Htmltemplates;
use App\services\templateservice\HtmlTemplateServices;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HtmlTplController extends AbstractController
{
    #[Route(path: "/backendmanagement/htmltemplatemanagement")]
    public function createHtmlTpl(EntityManagerInterface $entityManager, Request $request): Response
    {
        $response = "";
        $cssResponse = "";
        $selectedTpl = "";
        $htmlService = new HtmlTemplateServices($entityManager);
        $availableTpl = $htmlService->findAllHtmlTemplate();
        $selectedTpl = $request->request->get("availableHtlmTpl");
        $htmlTitle =  $request->request->get("htmlTitle");
        $searchHtml = $request->request->get("searchHtml");
        $forBackendOrFrontend = $request->request->get("forBackendOrFrontend");

        $desc =  $request->request->get("description");
        $rslt = false;
        $html = "";


        if ($searchHtml) {
            $html = $htmlService->findHtmlTemplateById($selectedTpl);
        }

        if ($selectedTpl && $desc && $htmlTitle) {
            $html = $htmlService->findHtmlTemplateById($selectedTpl);
            $html->setDescription($desc);
            $html->setTemplateName($htmlTitle);
            $html->setCreateDate(new DateTime(date("Y-m-d")));
            $html->setFrontOrBackend($forBackendOrFrontend);
            $entityManager->persist($html);
            $entityManager->flush();
            $rslt = true;
        }

        if (empty($selectedTpl) && $desc && $htmlTitle && empty($searchHtml)) {
            $html = new Htmltemplates();
            $html->setDescription($desc);
            $html->setTemplateName($htmlTitle);
            $html->setCreateDate(new DateTime(date("Y-m-d")));
            $html->setFrontOrBackend($forBackendOrFrontend);
            $rslt = $htmlService->insertNewHtmltTemplate($html);
        }

        if ($rslt) {
            $cssResponse = "color:green;";
            $response = "insert successful";
        }

        return $this->render('@backend/createHtmlTemplate.html.twig', [
            "value" => "Html template management",
            "cssResponse" =>  $cssResponse,
            "response" => $response,
            "htmlTpls" => $availableTpl,
            "selected" => $selectedTpl,
            "selectedHtml" => $html

        ]);
    }

    #[Route(path: "/backendmanagement/htmltemplatemanagement/all")]
    public function showAllTemplates(EntityManagerInterface $entityManager, Request $request): Response
    {
        $htmlService = new HtmlTemplateServices($entityManager);
        $availableTpl = $htmlService->findAllHtmlTemplate();
        $htmlUpdateFromList = $request->request->get("htmlUpdateFromList");
        $htmlTitle =  $request->request->get("htmlTitle");
        $desc =  $request->request->get("description");
        $forBackendOrFrontend = $request->request->get("forBackendOrFrontend");
        $response = "";
        $cssResponse = "";
        $rslt = false;

        $html = "";
        
        if ($htmlUpdateFromList && $desc && $htmlTitle && $forBackendOrFrontend) {
            $html = $htmlService->findHtmlTemplateById($htmlUpdateFromList);
            $html->setDescription($desc);
            $html->setTemplateName($htmlTitle);
            $html->setCreateDate(new DateTime(date("Y-m-d")));
            $html->setFrontOrBackend($forBackendOrFrontend);
            $entityManager->persist($html);
            $entityManager->flush();
            $rslt = true;
        }

        if ($rslt) {
            $cssResponse = "color:green;";
            $response = "insert successful";
        }

        return $this->render('@backend/allHtmlTemplate.html.twig', [
            "value" => "Html template management",
            "htmlTpls" => $availableTpl,
            "cssResponse" =>  $cssResponse,
            "response" => $response,
            "htmlupdate"=>$htmlUpdateFromList
        ]);
    }
}
