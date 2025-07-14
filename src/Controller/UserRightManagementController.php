<?php

namespace App\Controller;

use App\Entity\UserRightManagement;
use App\Entity\UserRights;
use App\services\logindataservice\LoginDataServices;
use App\services\userrightmanagement\UserRightMgServices;
use App\services\userrightservice\UserRightServices;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserRightManagementController extends AbstractController
{
    #[Route(path: "/backendmanagement/userrightmanagement/createUserRightGui", name: "createUserRightGui")]
    public function showInsertUserRightGui(Request $request, EntityManagerInterface $entityManager): Response
    {
        $x = (object)$this->getUser();

        if (!(in_array('ROLE_ADMIN_URM', $x->getRoles(), true) || in_array('ROLE_ADMIN', $x->getRoles(), true))) {
            return $this->render('@backend/permissionDenied.html.twig');
        }
        $cssResponse = $request->get("cssResponse");
        $response = $request->get("response");

        return $this->render('@backend/createUserRight.html.twig', ["value" => "Insert user right", "cssResponse" =>  $cssResponse, "response" => $response]);
    }

    #[Route("/backendmanagement/userrightmanagement/create", methods: ['POST'])]
    public function insertUserRight(Request $request, EntityManagerInterface $entityManager): Response
    {
        $x = (object)$this->getUser();

        if (!(in_array('ROLE_ADMIN_URM', $x->getRoles(), true) || in_array('ROLE_ADMIN', $x->getRoles(), true))) {
            return $this->render('@backend/permissionDenied.html.twig');
        }

        $userRs = new UserRightServices($entityManager);
        $userR = new UserRights();

        $abb = $request->request->get("abbreviation");
        $desc = $request->request->get("description");
        $righttitle = $request->request->get("righttitle");
        $action = $request->request->get("action");
        $rslt = false;

        $cssResponse = "color:red;";
        $response = "failed: it seems like some input field are emptied";

        if (!empty($abb) && !empty($desc) && !empty($righttitle)) {
            $userR->setAbbreviation($abb);
            $userR->setDescription($desc);
            $userR->setRightTitle($righttitle);
            $rslt = $userRs->insertUserRight($userR);
        }

        if ($rslt) {
            $cssResponse = "color:green;";
            $response = (strcmp($action, "insert") == 0) ? "insert new right successful" : "Update right successful";
        }
        $redirecToRouteName = (strcmp($action, "insert") == 0) ? "createUserRightGui" : "updateRightDefGui";
        return $this->redirectToRoute($redirecToRouteName, ["cssResponse" =>  $cssResponse, "response" => $response]);
    }

    #[Route("/backendmanagement/userrightmanagement/all")]
    public function allUserRight(EntityManagerInterface $entityManager): Response
    {
        $x = (object)$this->getUser();

        if (!(in_array('ROLE_ADMIN_URM', $x->getRoles(), true) || in_array('ROLE_ADMIN', $x->getRoles(), true))) {
            return $this->render('@backend/permissionDenied.html.twig');
        }
        $userRs = new UserRightServices($entityManager);
        $allUserR = $userRs->findAllUserRight();
        $arr = array();
        $i = 0;
        foreach ($allUserR as $x) {
            $arr[$i++] = array("id" => $x->getId(), "title" => $x->getRightTitle(), "abb" => $x->getAbbreviation(), "desc" => $x->getDescription());
        };

        return $this->render('@backend/allUserRight.html.twig', ["value" => "All user right", "userRights" =>  $arr]);
    }
    
    #[Route(path: "/backendmanagement/userrightmanagement/updateRightDefGui", name: "updateRightDefGui")]
    public function updateRight(Request $request, EntityManagerInterface $entityManager): Response
    {
        $x = (object)$this->getUser();

        if (!(in_array('ROLE_ADMIN_URM', $x->getRoles(), true) || in_array('ROLE_ADMIN', $x->getRoles(), true))) {
            return $this->render('@backend/permissionDenied.html.twig');
        }

        $userRs = new UserRightServices($entityManager);
        $allUserR = $userRs->findAllUserRight();

        $cssResponse = $request->get("cssResponse");
        $response = $request->get("response");


        return $this->render('@backend/updateUserRight.html.twig', [
            "value" => "Update user right",
            "userRights" =>  $allUserR,
            "cssResponse" =>  $cssResponse,
            "response" => $response,
        ]);
    }

    #[Route(path: "/backendmanagement/userrightmanagement/getrightbyid", name: "getrightbyid", methods: ["POST"])]
    public function searchRightById(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userRightServices = new UserRightServices($entityManager);
        $rghtId = $request->request->get("id");
        $right = [];
        if ($rghtId) {
            $x = $userRightServices->findUserRightById($rghtId);

            $right = array(
                "id" => $x->getId(),
                "rightTitle" => $x->getRightTitle(),
                "abbreviation" => $x->getAbbreviation(),
                "description" => $x->getDescription(),
                "createDate" => $x->getCreateDate()
            );
        }
        $json = json_encode($right);
        return new Response($json, 200, []);
    }

    #[Route(path: "/backendmanagement/userrightmanagement/deleterightbyid", name: "deleterightbyid", methods: ["POST"])]
    public function deleteRights(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userRightServices = new UserRightServices($entityManager);
        $rghtId = $request->request->get("id");
        $results = $userRightServices->deleteUserRight($rghtId);

        return new Response(($results) ? "delete right successful" : "delete right failed", 200, []);
    }
}
