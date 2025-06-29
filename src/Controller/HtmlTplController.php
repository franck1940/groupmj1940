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
    #[Route(path: "/backendmanagement/htmltemplatemanagement/htmlTemplateGui", name: "htmlTemplateGui")]
    public function createHtmlTpl(EntityManagerInterface $entityManager, Request $request): Response
    {
        $response = $request->get("response");
        $cssResponse = $request->get("cssResponse");
        $selectedTpl =  $request->get("selected");
        $htmlService = new HtmlTemplateServices($entityManager);
        $availableTpl = $htmlService->findAllHtmlTemplate();
        $selectedTpl = $request->request->get("selected");
        $html = ($selectedTpl) ? $htmlService->findHtmlTemplateById($selectedTpl) : null;


        return $this->render('@backend/createHtmlTemplate.html.twig', [
            "value" => "Html template management",
            "cssResponse" =>  $cssResponse,
            "response" => $response,
            "htmlTpls" => $availableTpl,
            "selected" => $selectedTpl,
            "selectedHtml" => $html

        ]);
    }

    #[Route(path: "/backendmanagement/htmltemplatemanagement/inserthtmlTemplate", name: "inserthtmlTemplate")]
    public function insertHtmlTpl(EntityManagerInterface $entityManager, Request $request): Response
    {

        $response = "ERROR: insert html template failed";
        $cssResponse = "color:red;";
        $selectedTpl = $request->request->get("availableHtlmTpl");
        $htmlService = new HtmlTemplateServices($entityManager);
        $htmlTitle =  $request->request->get("htmlTitle");
        $updateHtmlTpl = $request->request->get("updateHtmlTpl");

        $forBackendOrFrontend = $request->request->get("forBackendOrFrontend");
        $desc =  $request->request->get("description");
        $rslt = false;
        $html = "";

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
        $redirectTo = ($updateHtmlTpl) ? "allhtmlTplates" : "htmlTemplateGui";

        return $this->redirectToRoute($redirectTo, [
            "cssResponse" =>  $cssResponse,
            "response" => $response,
            "selected" => $selectedTpl,
            "htmlupdate" => $updateHtmlTpl
        ]);
    }

    #[Route(path: "/backendmanagement/htmltemplatemanagement/htmlTplById", name: "htmlTplById", methods: ["POST"])]
    public function getHtmlTemplate(EntityManagerInterface $entityManager, Request $request): Response
    {
        $htmlService = new HtmlTemplateServices($entityManager);
        $htmlId = $request->request->get("id");
        $result = [];

        if ($htmlId) {
            $x = $htmlService->findHtmlTemplateById($htmlId);
            $result["id"] = $x->getId();
            $result["templateName"] = $x->getTemplateName();
            $result["description"] = $x->getDescription();
            $result["frontOrBackend"] = $x->getFrontOrBackend();
        }

        $json = json_encode($result);
        return new Response($json, 200, []);
    }

    #[Route(path: "/backendmanagement/htmltemplatemanagement/deleteHtmlTemplate", name: "deleteHtmlTemplate", methods: ["POST"])]
    public function deleteHtmlTemplate(EntityManagerInterface $entityManager, Request $request): Response
    {
        $htmlService = new HtmlTemplateServices($entityManager);
        $htmlId = $request->request->get("id");
        $result = false;

        if ($htmlId) {
            $result = $htmlService->deleteAHtmltemplate($htmlId);
        }
        return new Response(($result) ? "successful" : "failed", 200, []);
    }

    #[Route(path: "/backendmanagement/htmltemplatemanagement/allhtmlTplates", name: "allhtmlTplates")]
    public function showAllTemplates(EntityManagerInterface $entityManager, Request $request): Response
    {
        $htmlService = new HtmlTemplateServices($entityManager);
        $availableTpl = $htmlService->findAllHtmlTemplate();
        $htmlUpdateFromList = $request->request->get("htmlupdate");
        $response = $request->get("response");
        $cssResponse = $request->get("cssResponse");

        return $this->render('@backend/allHtmlTemplate.html.twig', [
            "value" => "Html template management",
            "htmlTpls" => $availableTpl,
            "htmlupdate" => $htmlUpdateFromList,
            "cssResponse" =>  $cssResponse,
            "response" => $response,
        ]);
    }
}
