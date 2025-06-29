<?php

namespace App\Controller;

use App\Entity\UserHistoryOnline;
use App\Entity\Users;
use App\services\userhistoryonlineservice\UserHistoryOnlineServices;
use App\services\userservice\UserServices;
use DateTime;
use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Cast;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BackendController extends AbstractController
{
    //#[Route("/login")]
    public function showLoginPage(): Response
    {

        return $this->render('@backend/login.html.twig', ["value" => "Welcome to - GROUP NJ -"]);
    }

    #[Route(path: "/backendmanagement",  name: 'app_backendmanagement')]
    public function showBackendManagement(EntityManagerInterface $entityManager): Response
    {
        $userHistoryOnlineServices = new UserHistoryOnlineServices($entityManager);
        $userHistoryOnline = new UserHistoryOnline();
        $user = (object) $this->getUser();
        $verifyPw =  password_verify("groupnj1940", $user->getPassword());

        if ($verifyPw) {
            return $this->render('@backend/changePassword.html.twig', ["value" => "Change password"]);
        }
        //$userHtryOnline = $userHistoryOnlineServices->findUserHistoryOnlineByUser($user);
        $userHistoryOnline->setPerson($user);
        $userHistoryOnline->setStartDate(new DateTime(date("Y-m-d")));
        $userHistoryOnlineServices->insertUserHistoryOnline($userHistoryOnline);


        return $this->render('@backend/backendmanagement.html.twig', ["value" => "Welcome to groupnj backend management <br> Enter your credentials", "roles" => $user->getRoles()]);
    }

    #[Route(path: "/backendmanagement/logindatamanagement")]
    function fromLogindatamanagementTobackend()
    {
        return $this->redirectToRoute('app_backendmanagement');
    }


    #[Route(path: "/backendmanagement/usermanagement")]
    function fromUsermanagementTobackend()
    {
        return $this->redirectToRoute('app_backendmanagement');
    }

    #[Route(path: "/backendmanagement/userrightmanagement")]
    function fromUserrightmanagementTobackend()
    {
        return $this->redirectToRoute('app_backendmanagement');
    }

    #[Route(path: "/backendmanagement/pagecontentmanagement")]
    function fromPagecontentmanagementTobackend()
    {
        return $this->redirectToRoute('app_backendmanagement');
    }

    #[Route(path: "/backendmanagement/menumanagement")]
    function fromMenumanagementTobackend()
    {
        return $this->redirectToRoute('app_backendmanagement');
    }

    #[Route(path: "/backendmanagement/htmltemplatemanagement")]
    function fromHtmltemplatemanagementTobackend()
    {
        return $this->redirectToRoute('app_backendmanagement');
    }


    #[Route("/backendmanagement/userinsertpage")]
    public function showBackendInsertUserPage(): Response
    {
        // if ($id == 0)
        return $this->render('@backend/insertNewUser.html.twig', ["value" => "Insert new user"]);
    }




    #[Route("/backendmanagement/insertnewuser", methods: ['POST'])]
    public function  insertUsertNewUser(Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = new Users();
        $cssResponse = "";
        $response = "";
        $userServices = new UserServices($entityManager);
        $user->setLastname($request->request->get("lastname"));
        $user->setFirstname($request->request->get("firstname"));
        $user->setStreetName($request->request->get("streetname"));
        $user->setHouseNumber((int)($request->request->get("housenumber")));
        $user->setZipcode($request->request->get("zipcode"));
        $user->setPhoneNumber($request->request->get("phonenumber"));
        $user->setBirthday(new DateTime($request->request->get("birthday")));
        $user->setCountry($request->request->get("country"));
        $user->setTitle($request->request->get("title"));
        $user->setGender($request->request->get("gender"));
        $user->setCity($request->request->get("city"));
        $user->setEmail($request->request->get("email"));
        $rslt = $userServices->insertUser($user);
        if ($rslt) {
            $cssResponse = "color:green;";
            $response = "update successful";
        }
        return $this->render('@backend/insertNewUser.html.twig', ["value" => "Insert new user", "result" => $rslt, "cssResponse" => $cssResponse, "response" => $response]);
    }




    #[Route("/backendmanagement/inserttemplate", methods: ['POST'])]
    public function insertTemplate($entityManager) {}
}
