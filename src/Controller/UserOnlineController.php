<?php

namespace App\Controller;

use App\services\userhistoryonlineservice\UserHistoryOnlineServices;
use App\services\userloginservice\UserLoginServices;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserOnlineController extends AbstractController
{

    #[Route(path: "/backendmanagement/useronline/alluseronline", name: "alluseronline", methods: ["POST"])]
    public function todayUserOnline(EntityManagerInterface $entityManager, Request $request): Response
    {
        $userHistoryServices = new UserHistoryOnlineServices($entityManager);
        // $loginUserServices = new UserLoginServices($entityManager);
        $users = [];

        $userOnlyToday = $userHistoryServices->findUserHistoryOnlineByStartDate(new DateTime(date("Y-m-d H:i:s")));

        foreach ($userOnlyToday as $x) {
            array_push($users, array("username" => $x->getPerson()->getUsers()->getFirstname(), "Identification" => $x->getId()));
        }

        $json = json_encode($users);
        return new Response($json, 200, []);
    }
}
