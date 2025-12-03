<?php

namespace App\Controller;

use App\Entity\Projects;
use App\services\projectservice\Projectservices;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Builder\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeesActivitiesController extends AbstractController
{
    #[Route(path: "/backendmanagement/employeesActivities/insertGui", name: 'app_insertProjectGui')]
    public function ShowInsertCompanyProjectGui(EntityManagerInterface $entityManager,  Request $request)
    {
        $createDate = date("Y-m-d H:i:s");
        $projectServices = new Projectservices($entityManager);
        $existingProject = $projectServices->findAllProjects();

        $response = $request->get("response");
        $cssResponse = $request->get("cssResponse");

        return $this->render('@backend/InsertCompanyProject.html.twig', [
            "value" => "Insert new project",
            "allprojects" => $existingProject,
            "selected" => "",
            "createDate" => $createDate,
            "response" => $response,
            "cssResponse" => $cssResponse
        ]);
    }

    #[Route(path: "/backendmanagement/employeesActivities/insertproject", methods: ["POST"], name: 'app_insertAproject')]
    public function insertCompanyProjects(EntityManagerInterface $entityManager,  Request $request)
    {

        $projectServices = new Projectservices($entityManager);

        $response = "ERROR:Insert project failed";
        $cssResponse = "color:red;";

        $resultSuccessful = true;

        $existingProject = $request->request->get("existingProject");
        $title = $request->request->get("projectname");
        $desc = $request->request->get("projectDescription");
        $createDate = $request->request->get("projectCreateDate");
        $startDate = $request->request->get("projectStartDate");
        $endDate = $request->request->get("projectEndDate");
        $insertProject = $request->request->get("insertproject");
        $updateProject = $request->request->get("updateproject");


        $entityOfTheExistingproject = null;

        if (empty($title)) {
            $response = $response . "[Title missing]";
            $resultSuccessful = false;
        }

        if (empty($desc)) {
            $response = $response . "[Description missing]";
            $resultSuccessful = false;
        }

        if (empty($createDate)) {
            $response = $response . "[Create date missing]";
            $resultSuccessful = false;
        }

        if (empty($startDate)) {
            $response = $response . "[start date missing]";
            $resultSuccessful = false;
        }

        if (empty($endDate)) {
            $response = $response . "[End date missing]";
            $resultSuccessful = false;
        }

        if ($existingProject && $resultSuccessful) {
            $entityOfTheExistingproject = $projectServices->findProjectByPid($existingProject);
            $entityOfTheExistingproject->setTitle(trim($title));
            $entityOfTheExistingproject->setDescription(trim($desc));
            $entityOfTheExistingproject->setEndDate(new DateTime($endDate));
            $entityOfTheExistingproject->setStartDate(new DateTime($startDate));
            $resultSuccessful = $projectServices->insertNewProject($entityOfTheExistingproject);
        }

        if (empty($existingProject) && $resultSuccessful) {
            $pt = new Projects();
            $pt->setUser($this->getUser());
            $pt->setTitle(trim($title));
            $pt->setDescription(trim($desc));
            $pt->setCreatedate(new DateTime($createDate));
            $pt->setEndDate(new DateTime($endDate));
            $pt->setStartDate(new DateTime($startDate));
            $resultSuccessful = $projectServices->insertNewProject($pt);
        }

        if ($resultSuccessful) {
            $response = "Insert project [successfull]";
            $cssResponse = "color:green;";
        }

        if($insertProject)
        return $this->redirectToRoute('app_insertProjectGui', ["response" => $response, "cssResponse" => $cssResponse]);

       if($updateProject)
        return $this->redirectToRoute('app_allprojects', ["response" => $response, "cssResponse" => $cssResponse, "updateproject"=>$updateProject]);

    }

    #[Route(path: "/backendmanagement/employeesActivities/allprojects", name: 'app_allprojects')]
    public function showAllProjects(EntityManagerInterface $entityManager,Request $request)
    {
        $projectServices = new Projectservices($entityManager);
        $existingProject = $projectServices->findAllProjects();
         $updateProject = $request->get("updateproject");
         $response = $request->get("response");
        $cssResponse = $request->get("cssResponse");
        return $this->render('@backend/allProject.html.twig', [
            "value" => "List all projects",
            "allprojects" => $existingProject,
            "updateproject"=> ($updateProject)? $updateProject: "no",
            "response" => $response,
            "cssResponse" => $cssResponse
        ]);
    }

    #[Route(path: "/backendmanagement/employeesActivities/deleteproject",methods:["POST"], name: 'deleteproject')]
    public function deleteProjects(EntityManagerInterface $entityManager,Request $request): Response
    {
         $id = $request->request->get("id");
        $projectServices = new Projectservices($entityManager);

         $results = $projectServices ->deleteById($id);
       
        return new Response(($results)?"successful":"failed",200,[]);
    }


}
