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
    #[Route("/backendmanagement/userrightmanagement/createUserRightGui")]
    public function showInsertUserRightGui(Request $request, EntityManagerInterface $entityManager): Response
    {
        $x = (object)$this->getUser();

        if (!(in_array('ROLE_ADMIN_URM', $x->getRoles(), true) || in_array('ROLE_ADMIN', $x->getRoles(), true))) {
            return $this->render('@backend/permissionDenied.html.twig');
        }

        return $this->render('@backend/createUserRight.html.twig', ["value" => "Insert user right", "cssResponse" => "", "response" => ""]);
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
        $rslt = false;

        $cssResponse = "color:red;";
        $reponse = "failed: it seems like some input field are emptied";

        if (!empty($abb) && !empty($desc) && !empty($righttitle)) {
            $userR->setAbbreviation($abb);
            $userR->setDescription($desc);
            $userR->setRightTitle($righttitle);
            $rslt = $userRs->insertUserRight($userR);
        }

        if ($rslt) {
            $cssResponse = "color:green;";
            $reponse = "insert successful";
        }

        return $this->render('@backend/createUserRight.html.twig', ["value" => "Insert user right", "cssResponse" =>  $cssResponse, "response" => $reponse]);
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
            $arr[$i++] = array("title" => $x->getRightTitle(), "abb" => $x->getAbbreviation(), "desc" => $x->getDescription());
        };

        return $this->render('@backend/allUserRight.html.twig', ["value" => "All user right", "userRights" =>  $arr]);
    }

    #[Route("/backendmanagement/userrightmanagement/update")]
    public function updateRight(Request $request, EntityManagerInterface $entityManager): Response
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
            $arr[$i++] = array("title" => $x->getRightTitle());
        };


        $abb = $request->request->get("abbreviation");
        $desc = $request->request->get("description");
        $title = $request->request->get("title");
        $sendbyFunc =  $request->request->get("sendbyfunc");

        $selectedtitle = $request->request->get("selectedtitle");


        $description = "";
        $abbreviation = "";
        $arrByTitle = [];
        $titleQ = "";
        $id = "";
        if (!empty($selectedtitle)) {
            $arrByTitle = $userRs->findUserRightByName($selectedtitle);
            $description = $arrByTitle[0]->getDescription();
            $abbreviation = $arrByTitle[0]->getAbbreviation();
            $titleQ = $arrByTitle[0]->getRightTitle();
            $id = $arrByTitle[0]->getId();
        }
        $rslt = false;

        $cssResponse = "";
        $reponse = "";

        if (!empty($abb) && !empty($desc) && !empty($title) && empty($sendbyFunc)) {
            $cssResponse = "color:red;";
            $reponse = "update failed: it seems like some input field are emptied";
        }


        if (!empty($abb) && !empty($desc) && !empty($title) && empty($sendbyFunc)) {
            $r = $userRs->findUserRightById($id);
            $r->setAbbreviation($abb);
            $r->setDescription($desc);
            $r->setRightTitle($title);
            $rslt = $userRs->updateUserRight($r);
        }

        if ($rslt) {
            $cssResponse = "color:green;";
            $reponse = "update successful";
        }

        return $this->render('@backend/updateUserRight.html.twig', [
            "value" => "Update user right",
            "userRights" =>  $arr,
            "cssResponse" =>  $cssResponse,
            "response" => $reponse,
            "desc" => $description,
            "abbr" => $abbreviation,
            "title" => $titleQ,
            "selectedtitle" => ($selectedtitle) ? "selected" : "",
            "slvalue" => $selectedtitle
        ]);
    }

    #[Route("/backendmanagement/userrightmanagement/insertright")]
    public function insertRight(Request $request, EntityManagerInterface $entityManager)
    {
        $x = (object)$this->getUser();

        if (!(in_array('ROLE_ADMIN_URM', $x->getRoles(), true) || in_array('ROLE_ADMIN', $x->getRoles(), true))) {
            return $this->render('@backend/permissionDenied.html.twig');
        }

        $userRihghtService = new UserRightServices($entityManager);
        $rights = $userRihghtService->findAllUserRight();
        $userRightMgServices = new UserRightMgServices($entityManager);
        $loginDataServices = new LoginDataServices($entityManager);
        $loginnames = $loginDataServices->findAllLogindata();

        $lgRequest =  $request->request->get("loginname");
        $rqFunc = $request->request->get("rf");

        $currentUserRights = [];
        $remainings = [];
        $results =  [];
        $l = null;

        $l = ($lgRequest) ? $loginDataServices->findById($lgRequest) : null;

        if ($l) {
            if ($l->getUserrightmg()) {
                $keys = $l->getUserrightmg()->getUserRight()->getKeys();
                foreach ($keys as $y) {
                    array_push($currentUserRights, $l->getUserrightmg()->getUserRight()->get($y));
                }
                foreach ($rights as $x) {
                    $cf = false;
                    $val = null;
                    foreach ($currentUserRights as $d) {
                        $val = $x;
                        if ($d->getAbbreviation() == $x->getAbbreviation()) {
                            $cf = true;
                            break;
                        }
                    }
                    if (!$cf) {
                        array_push($remainings, $val);
                    }
                }
            }
        }

        $results["selected"] = (count($currentUserRights) > 0) ? $currentUserRights : [];
        $results["deselected"] = (count($currentUserRights) > 0) ? $remainings : $rights;



        $arr = new ArrayCollection();

        $cssResponse = "";
        $reponse = "";

        if (!empty($lgRequest) && empty($rqFunc)) {
            $remainings = [];
            foreach ($rights as $x) {
                $rghtGetR = $request->request->get($x->getAbbreviation());
                if ($rghtGetR) {
                    $arr->add($x);
                } else {
                    array_push($remainings, $x);
                }
            }
            $results["selected"] = (count($arr) > 0) ? $arr : [];
            $results["deselected"] = (count($arr) > 0) ? $remainings : $rights;

            $logindata = $loginDataServices->findById($lgRequest);

            if ($logindata->getId() && !empty($arr)) {

                $rslt = false;
                $userRightManagement = new UserRightManagement();
                $userRightManagement->setLogindata($logindata);

                if (!$logindata->getUserrightmg()) {
                    $logindata->setUserrightmg($userRightManagement);
                    $userRightMgServices->insertUserRightMgData($userRightManagement);
                    $userRightManagement->setUserRight($arr);
                    $rslt = $userRightMgServices->insertUserRightMgData($userRightManagement);
                } else {
                    $logindata->getUserrightmg()->setUserRight($arr);
                    $entityManager->persist($logindata);
                    $entityManager->flush();
                    $rslt = true;
                }


                if ($rslt) {
                    $cssResponse = "color:green; margin-left:5px;";
                    $reponse = "insert right successfully done";
                } else {
                    $cssResponse = "color:red; margin-left:5px;";
                    $reponse = "insert right failed";
                }
            }
        }

        return $this->render('@backend/userRightManagementGui.html.twig', [
            "value" => "User right management",
            "userRights" =>  $results,
            "loginnames" => $loginnames,
            "cssResponse" =>  $cssResponse,
            "response" => $reponse,
            "selected" => $lgRequest
        ]);
    }
}
