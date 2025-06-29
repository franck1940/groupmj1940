<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Users;
use App\services\userloginservice\UserLoginServices;
use App\services\userservice\UserServices;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsermanagementController extends AbstractController
{
    #[Route(path: "/backendmanagement/usermanagement/insertGui", name: "insertGui")]
    public function showInsertUserGui(Request $request,)
    {
        $x = (object)$this->getUser();

        if (!(in_array('ROLE_ADMIN_UM', $x->getRoles(), true) || in_array('ROLE_ADMIN', $x->getRoles(), true))) {
            return $this->render('@backend/permissionDenied.html.twig');
        }

        $cssResponse = $request->get("cssResponse");
        $response = $request->get("response");
        return $this->render('@backend/insertNewUser.html.twig', [
            "value" => "Insert new user ",
            "cssResponse" => $cssResponse,
            "response" => $response
        ]);
    }

    #[Route(path: "/backendmanagement/usermanagement/updateUserGui", name: "updateUserGui")]
    public function showUserProfil(Request $request, EntityManagerInterface $entityManager)
    {
        $x = (object)$this->getUser();

        if (!(in_array('ROLE_USER', $x->getRoles(), true) ||  in_array('ROLE_EMP', $x->getRoles(), true))) {
            return $this->render('@backend/permissionDenied.html.twig');
        }

        $cssResponse = $request->get("cssResponse");
        $response = $request->get("response");
        $user = ((object) $this->getUser())->getUsers();

        return  $this->render('@backend/profil.html.twig', [
            "value" => "My Profil  [" . $user->getEmail() . "]",
            "cssResponse" => $cssResponse,
            "response" => $response,
            "users" => $user
        ]);
    }

    #[Route(path: "/backendmanagement/usermanagement/saveNewprofile", name: "saveNewprofile", methods: ["POST"])]
    function saveNewProfile(Request $request, EntityManagerInterface $entityManager)
    {
        $cssResponse = "color:red;";
        $response = "ERROR: update profile failed";
        $uploadProfile = 1;
        $userServices = new UserServices($entityManager);
        $userLoginServices = new UserLoginServices($entityManager);
        $selectedUser = $request->request->get("selectedUser");

        $actionSender = $request->request->get("action");
        $file = $_FILES["picture"]["name"];

        $target_dir = "uploads/";

        if (isset($_FILES["picture"]["name"]) &&  $file) {
            $target_file = $target_dir . basename($_FILES["picture"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $checkPictutre = getimagesize($_FILES["picture"]["tmp_name"]);
            if (!$checkPictutre) {
                $response = $response . "[" . "File is an image - " . $checkPictutre["mime"] . "].";
                $uploadProfile = 0;
            }
            if (file_exists($target_file)) {
                $response = $response . "[Sorry, file already exists.]";
                $uploadProfile = 1;
            }
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $response = $response . ":[Sorry, only JPG, JPEG, PNG & GIF files are allowed.]";
                $uploadProfile = 0;
            }
        }
        $lastname = $request->request->get("lastname");

        if (empty($lastname)) {
            $response = $response . ":[Lastname is empty]";
            $uploadProfile = 0;
        }
        $firstname = $request->request->get("firstname");
        if (empty($firstname)) {
            $response = $response . ":[firstname is empty]";
            $uploadProfile = 0;
        }
        $housenumber = $request->request->get("housenumber");
        if (empty($housenumber)) {
            $response = $response . ":[house number is empty]";
            $uploadProfile = 0;
        }
        $streetNumber = $request->request->get("streetname");
        if (empty($streetNumber)) {
            $response = $response . ":[street number is empty]";
            $uploadProfile = 0;
        }
        $zipcode = $request->request->get("zipcode");
        if (empty($zipcode)) {
            $response = $response . ":[zipcode is empty]";
            $uploadProfile = 0;
        }
        $phoneNumber = $request->request->get("phonenumber");

        if (empty($phoneNumber)) {
            $response = $response . ":[phoneNumber is empty]";
            $uploadProfile = 0;
        }

        $birthdate = $request->request->get("birthday");
        if (empty($birthdate)) {
            $response = $response . ":[birthdate is empty]";
            $uploadProfile = 0;
        }

        $country = $request->request->get("country");
        if (empty($country)) {
            $response = $response . ":[country is empty]";
            $uploadProfile = 0;
        }

        $gender = $request->request->get("gender");

        if (empty($gender)) {
            $response = $response . ":[Gender is empty]";
            $uploadProfile = 0;
        }
        $city = $request->request->get("city");
        if (empty($city)) {
            $response = $response . ":[city is empty]";
            $uploadProfile = 0;
        }

        $email = $request->request->get("email");

        if (empty($email)) {
            $response = $response . ":[Email is empty]";
            $uploadProfile = 0;
        }
        //$picture = $request->request->get("picture");
         $checkUser = null;

        if ($uploadProfile) {
            $cssResponse = "color:green;";
            $response = "update profile successful";
            $user = new Users();
            $isNewUser = false;
            $rslt =false;
            $loginUser=null;
            if(strcmp($actionSender, "insertNewUser") == 0)
            {
              $checkUser = $userServices->findUserByEmail($email)[0];
              $isNewUser =true;
            }

            if (strcmp($actionSender, "updateMyProfile") == 0) {
                $user = ((object) $this->getUser())->getUsers();
                $loginUser = $userLoginServices->findUserByEmail($user->getEmail());
            }

            if (strcmp($actionSender, "updateAnyProfile") == 0) {
                $user = $userServices->findUserById($selectedUser);
                $checkUser = $user;
                $loginUser = $userLoginServices->findByUsers($user);
            }
            

            if ($file) {

                if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                    $response = $response . "The file " . htmlspecialchars(basename($_FILES["picture"]["name"])) . " has been uploaded.";
                } else {
                    $response = $response . "Sorry, there was an error uploading your file. to " . $target_file;
                }

                $filename = pathinfo($_FILES['picture']['name'], PATHINFO_FILENAME);
                $filename = $filename . "." . $imageFileType;
                $user->setPicture($filename);
            }


            $user->setLastname($lastname);
            $user->setFirstname($firstname);
            $user->setStreetName($streetNumber);
            $user->setHouseNumber((int)($housenumber));
            $user->setZipcode($zipcode);
            $user->setPhoneNumber($phoneNumber);
            $user->setBirthday(new DateTime($birthdate));
            $user->setCountry($country);
            $user->setTitle($request->request->get("title"));
            $user->setGender($gender);
            $user->setCity($city);
            $user->setEmail($email);

            // echo $_FILES["picture"]["tmp_name"];
            // $source =$_FILES["picture"]["tmp_name"];

            if (!$isNewUser) {

                $rslt = $userServices->insertUser($user);
                
                if($loginUser)
                {
                    if(strcmp($user->getEmail(), $loginUser->getEmail())!=0)
                    {
                        $loginUser->setEmail($user->getEmail());
                        $rslt =$userLoginServices->insertUser($loginUser);
                    }
              }
            }

            if($isNewUser && !$checkUser)
            {
                $rslt = $userServices->insertUser($user);
            }

            if ($isNewUser && $checkUser) {
                $cssResponse = "color:red;";
                $response = "User[" . $email . "] already exists";
            }

            if (!$isNewUser) {
                $cssResponse = (!$rslt) ? "color:red;" : "color:green;";
                $response = (!$rslt) ? " update profile failed" : $response;
            }

            if ($isNewUser) {

                $cssResponse = (!$rslt) ? "color:red;" : "color:green;";
                $response = (!$rslt) ? "insert user failed" . $response : "insert user successful";
            }
        }

        $routeToGui = (strcmp($actionSender, "updateMyProfile") == 0) ? "updateUserGui" : ((strcmp($actionSender, "insertNewUser") == 0) ? "insertUserGui" : "updateAnyProfileGui");

        return $this->redirectToRoute($routeToGui, [
            "cssResponse" =>  $cssResponse,
            "response" => $response
        ]);
    }

    #[Route(path: "/backendmanagement/usermanagement/insertUserGui", name: "insertUserGui")]
    public function insertNewUser(Request $request, EntityManagerInterface $entityManager)
    {
        $x = (object)$this->getUser();
        if (!(in_array('ROLE_ADMIN_UM', $x->getRoles(), true) || in_array('ROLE_ADMIN', $x->getRoles(), true))) {
            return $this->render('@backend/permissionDenied.html.twig');
        }


        $cssResponse = $request->get("cssResponse");
        $response = $request->get("response");


        return $this->redirectToRoute("insertGui", [
            "cssResponse" => $cssResponse,
            "response" => $response
        ]);
    }


    #[Route(path: "/backendmanagement/usermanagement/updateAnyProfileGui", name: "updateAnyProfileGui")]
    public function updateUser(EntityManagerInterface $entityManager, Request $request)
    {
        $x = (object)$this->getUser();
        if (!(in_array('ROLE_ADMIN_UM', $x->getRoles(), true) || in_array('ROLE_ADMIN', $x->getRoles(), true))) {
            return $this->render('@backend/permissionDenied.html.twig');
        }

        $cssResponse = $request->get("cssResponse");
        $response = $request->get("response");
        $userService = new UserServices($entityManager);
        $alluser = $userService->findAllUser();

        return $this->render('@backend/updateUser.html.twig', [
            "value" => "User update management",
            "allusers" => $alluser,
            "cssResponse" => $cssResponse,
            "response" => $response
        ]);
    }

    #[Route(path: "/backendmanagement/usermanagement/getSelectedUser", name: "getSelectedUser")]
    public function getUserBySelectedId(EntityManagerInterface $entityManager, Request $request): Response
    {
        $id = $request->request->get("id");
        $userService = new UserServices($entityManager);
        $rslt = "";
        $arr = [];
        $message = "failed";

        if ($id) {

            $aUser = $userService->findUserById($id);

            $arr = array(
                "id" => $aUser->getId(),
                "gender" => $aUser->getGender(),
                "title" => $aUser->getTitle(),
                "firstname" => $aUser->getFirstname(),
                "lastname" => $aUser->getLastname(),
                "email" => $aUser->getEmail(),
                "phonenumber" => $aUser->getPhoneNumber(),
                "StreetName" => $aUser->getStreetName(),
                "HouseNumber" => $aUser->getHouseNumber(),
                "zipcode" => $aUser->getZipcode(),
                "city" => $aUser->getCity(),
                "country" => $aUser->getCountry(),
                "birthday" => $aUser->getBirthday(),
                "picture" => $aUser->getPicture()
            );

            $rslt = json_encode($arr);
            $message = "successful";
        }

        return new Response($rslt, 200, [$message]);
    }
    #[Route(path: "/backendmanagement/usermanagement/all", name: "all")]
    public function showAllUsers(EntityManagerInterface $entityManager)
    {
        $x = (object)$this->getUser();
        if (!(in_array('ROLE_ADMIN_UM', $x->getRoles(), true) || in_array('ROLE_ADMIN', $x->getRoles(), true))) {
            return $this->render('@backend/permissionDenied.html.twig');
        }

        $userServices = new UserServices($entityManager);
        $headers   =
            array(
                "First name",
                "Last name",
                "Email",
                "Phone Number",
                "Street name",
                "House name",
                "Picture"
            );

        $allusers = $userServices->findAllUser();
        return $this->render('@backend/allUsers.html.twig', ["value" => "All Users", "headers" => $headers, "users" => $allusers]);
    }



    #[Route("/backendmanagement/usermanagement/deleteuser", methods: ['POST'], name: "deleteuser")]
    public function deleteUser(EntityManagerInterface $entityManager, Request $request)
    {
        $x = (object)$this->getUser();

        if (!(in_array('ROLE_ADMIN_UM', $x->getRoles(), true) || in_array('ROLE_ADMIN', $x->getRoles(), true))) {
           return new Response("Your permission is not sufficiant to delete a user", 200, []);
        }

        $userServices = new UserServices($entityManager);
        $userId = $request->request->get("id");
        $isDelete = false;
        if ($userId) {
            $usersToBeDelete =  $userServices->findUserById($userId);

            if ($usersToBeDelete) {

                $loginUser = $entityManager->getRepository(User::class)->findOneBy(["users" => $usersToBeDelete]);

                if ($loginUser) {
                    $entityManager->remove($loginUser);
                     $entityManager->flush();
                }
                $userServices->deleteUser($userId);
            }
            $isDelete = true;

            return new Response(($isDelete) ? "successful" : "failed", 200, []);
        }
    }
}
