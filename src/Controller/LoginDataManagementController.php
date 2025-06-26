<?php

namespace App\Controller;

use App\Entity\Logindata;
use App\Entity\User;
use App\Entity\UserRightManagement;
use App\Entity\UserRights;
use App\services\logindataservice\LoginDataServices;
use App\services\userloginservice\UserLoginServices;
use App\services\userrightmanagement\UserRightMgServices;
use App\services\userrightservice\UserRightServices;
use App\services\userservice\UserServices;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Totp\TotpAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginDataManagementController extends AbstractController
{

    #[Route("/backendmanagement/logindatamanagement/insertrights")]
    public function showLoginDataInsertGui(EntityManagerInterface $entityManager, Request $request)
    {
        $x = (object)$this->getUser();

        if (!(in_array('ROLE_ADMIN_LM', $x->getRoles(), true) || in_array('ROLE_ADMIN', $x->getRoles(), true))) {
            return $this->render('@backend/permissionDenied.html.twig');
        }

        $userServices = new UserServices($entityManager);
        $userRihghtService = new UserRightServices($entityManager);
        $userLoginServices = new UserLoginServices($entityManager);
        $rights = $userRihghtService->findAllUserRight();

        $userId = $request->request->get("userlogin");

        $user = ($userId) ? $userServices->findUserById($userId) : null;

        $cssResponse = "color:red;";
        $response = "added user Rights for [" . $user->getEmail() . "] failed";

        $loginUser = ($userId) ? $userLoginServices->findUserByEmail($user->getEmail()) : null;

        if ($user) {


            $arr = [];
            $rslt = false;
            $arrRights = new ArrayCollection();
            foreach ($rights as $x) {
                $rghtGetR = $request->request->get($x->getAbbreviation());
                if ($rghtGetR) {
                    $arrRights->add($x);
                    array_push($arr, $x->getAbbreviation());
                }
            }

            $loginUser->setRoles($arr);
            $loginUser->setUserRight($arrRights);
            $rslt = $userLoginServices->insertUser($loginUser);

            if ($rslt) {
                $cssResponse = "color:green;";
                $response = "Rights for [" . $user->getEmail() . "] has been successfully inserted/added";
            }
        }

        return $this->redirectToRoute('showLoginRightMgt', [
            "cssResponse" => $cssResponse,
            "response" => $response
        ]);
    }


    #[Route(path: "/backendmanagement/logindatamanagement/showLoginRightMgt", name: "showLoginRightMgt")]
    function showRightMgtGui(EntityManagerInterface $entityManager, Request $request)
    {
        $cssResponse = $request->get("cssResponse");
        $response = $request->get("response");
        $userServices = new UserServices($entityManager);
        $userLoginServices = new UserLoginServices($entityManager);
        $userRihghtServices = new UserRightServices($entityManager);

        $users = $userServices->findAllUser();
        $allRights = $userRihghtServices->findAllUserRight();
        $lgUser = [];
        foreach ($users as $x) {
            $k =  $userLoginServices->findUserByEmail($x->getEmail());
            if ($k) {
                array_push($lgUser, $x);
            }
        }
        $users = $lgUser;

        return $this->render('@backend/loginRightsMgts.html.twig', [
            "value" => "Login right manageement",
            "users" => $users,
            "cssResponse" => $cssResponse,
            "response" => $response,
            "userRights" => $allRights,
        ]);
    }

    #[Route(path: "/backendmanagement/logindatamanagement/loginRights", name: "loginRights", methods: ["POST"])]
    function getLoginUserRights(EntityManagerInterface $entityManager, Request $request)
    {
        $userServices = new UserServices($entityManager);
        $userLoginServices = new UserLoginServices($entityManager);
        $userId = $request->request->get("id");

        $rights = [];

        if ($userId) {
            $user = $userServices->findUserById($userId);
            $rghts = $userLoginServices->findUserByEmail($user->getEmail());
            $roles = $rghts->getRoles();
            $i = 0;
            foreach ($roles as $val) {
                $rights["0" . ($i++)] = $val;
            }
        }
        $json = json_encode($rights);
        return new Response($json, 200, []);
    }

    #[Route("/backendmanagement/logindatamanagement/all")]
    public function showAllLogin(EntityManagerInterface $entityManager, Request $request)
    {
        $x = (object)$this->getUser();

        if (!(in_array('ROLE_ADMIN_LM', $x->getRoles(), true) || in_array('ROLE_ADMIN', $x->getRoles(), true))) {
            return $this->render('@backend/permissionDenied.html.twig');
        }

        $userServices = new UserServices($entityManager);
        $userLoginServices = new UserLoginServices($entityManager);

        $deleteThisLogin = $request->request->get("deleteThisLogin");

        $response = "";
        $email = "";
        $cssResponse = "";
        $rslt = false;

        if ($deleteThisLogin) {
            $rslt = $userLoginServices->deleteUser($deleteThisLogin);
        }

        $users = $userServices->findAllUser();
        $allLoginUser = $userLoginServices->findAllUser();
        $headers = ["Name", "Roles"];
        if ($rslt) {
            $cssResponse = "color:green;";
            $response = "insert successful";
        }


        return $this->render('@backend/allLogins.html.twig', [
            "value" => "All logins",
            "users" => $users,
            "email" => $email,
            "headers" => $headers,
            "allLogins" => $allLoginUser,
            "cssResponse" => $cssResponse,
            "response" => $response,
        ]);
    }


    #[Route("/backendmanagement/logindatamanagement/changepassword")]
    public function doChangePassword(EntityManagerInterface $entityManager, Request $request, TotpAuthenticatorInterface $totpAuthenticator)
    {
        $password1 = $request->request->get("password1");
        $password2 = $request->request->get("password2");
        $val = strcmp($password1, $password2);


        if ($val != 0 || empty($password1) || empty($password2)) {
            return $this->redirectToRoute('app_backendmanagement');
        }

        $hash = password_hash(trim($password1), PASSWORD_DEFAULT);
        $user = (object)$this->getUser();
        $user->setPassword($hash);
        $entityManager->persist($user);
        $entityManager->flush();
        if (!$user->isTotpAuthenticationEnabled()) {
            $user->setTotpSecret($totpAuthenticator->generateSecret());
            $entityManager->flush();

            return $this->render('@backend/qrCodeToScan.html.twig');
        }

        return   $this->redirectToRoute('app_backendmanagement');
    }

    #[Route(path: "/backendmanagement/logindatamanagement/resetLoginPasswordGui", name: "resetLoginPasswordGui")]
    public function resetPassword(EntityManagerInterface $entityManager, Request $request): Response
    {
        $cssResponse = $request->get("cssResponse");
        $response = $request->get("response");
        $userServices = new UserServices($entityManager);
        $users = $userServices->findAllUser();
        $insertOrRestLogin = $request->get("lgf");
        $userLoginServices = new UserLoginServices($entityManager);
        $guiTitle = "Reset login password";
        $lgUser = [];
        $nolgUser = [];
        $action = "";
        $linkval = "";
        if ($insertOrRestLogin) {
            foreach ($users as $x) {
                $k = $userLoginServices->findUserByEmail($x->getEmail());
                if ($k) {
                    array_push($lgUser, $x);
                } else {
                    array_push($nolgUser, $x);
                }
            }
            if (strcmp($insertOrRestLogin, "r") == 0) {
                $guiTitle = "Reset login password";
                $users = $lgUser;
                $action = "Reset passwort";
            } else {
                $guiTitle = "Insert login user";
                $users = $nolgUser;
                $action = "Insert login";
            }
        }

        return $this->render('@backend/loginUserMgt.html.twig', [
            "value" =>  $guiTitle,
            "users" => $users,
            "response" => $response,
            "cssResponse" => $cssResponse,
            "action" => $action,
            "lgf" => $insertOrRestLogin
        ]);
    }

    #[Route(path: "/backendmanagement/logindatamanagement/saveNewPassword", name: "saveNewPassword", methods: ["POST"])]
    public function saveResetPassword(EntityManagerInterface $entityManager, Request $request): Response
    {
        $cssResponse = "color:red;";
        $response = "ERROR: Reset user password failed";
        $userLoginServices = new UserLoginServices($entityManager);
        $password = $request->request->get("password");
        $action = $request->request->get("action");
        $email = $request->request->get("email");
        if ($email && $password) {
            $existEmail = $userLoginServices->findUserByEmail($email);
            $pwdHash = password_hash($password, PASSWORD_DEFAULT);
            $rslt = false;
            if ($existEmail) {

                $existEmail->setPassword($pwdHash);
                 $existEmail->setTotpSecret(null);
                $rslt = $userLoginServices->insertUser($existEmail);
                if ($rslt) {
                    $cssResponse = "color:green;";
                    $response = "Password reset successful";
                }
            }

            if (strcmp($action, "i") == 0) {
                $login = new User();
                $login->setPassword($pwdHash);
                $login->setRoles(["ROLE_USER"]);
                $login->setEmail($email);
                $rslt = $userLoginServices->insertUser($login);
            }

            if ($rslt) {
                $cssResponse = "color:green;";
                $response = "Password reset successful";
            }

            if (!$rslt) {
                $response = $response . "[User is not among the login user, therefore password can not be reseted. User has to be inserted als login]";
            }
        }


        return $this->redirectToRoute('resetLoginPasswordGui', [
            "lgf" => $action,
            "response" => $response,
            "cssResponse" => $cssResponse
        ]);
    }

    #[Route(path: "/backendmanagement/logindatamanagement/getemail", name: "getemail")]
    public function searchUserEmail(EntityManagerInterface $entityManager, Request $request): Response
    {
        $userServices = new UserServices($entityManager);
        $userId = $request->request->get("id");
        $email = "";
        if ($userId) {
            $user = $userServices->findUserById($userId);
            $email = $user->getEmail();
        }

        return new Response($email, 200, []);
    }
}
