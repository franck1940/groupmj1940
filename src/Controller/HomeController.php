<?php

namespace App\Controller;

use App\Entity\Contact;
use App\services\contactservice\ContactServices;
use App\services\menuservice\MenuServices;
use App\services\pgcontentservices\PageContentsServices;
use App\utils\DataUtils;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;


class HomeController extends AbstractController
{
    #[Route(path: '/', name: "app_home")]
    public function showHome(EntityManagerInterface $entityManager): Response
    {

        $rslt  = (new DataUtils($entityManager))->getStructuredMenus();
        $contentWithMenus = (new DataUtils($entityManager))->getContentsWithTheirMenus();
        return $this->render('@frontend/home.html.twig', ["allMenus" => $rslt, "ctsWithMenus" => $contentWithMenus]);
    }

    #[Route(path: "/home")]
    public function gotToHome(): Response
    {
        return $this->redirectToRoute('app_home');
    }


    // #[Route(path: '/grpfd/{routmenu}')]
    // public function handelfdRouteMenu(string $routmenu, EntityManagerInterface $entityManager): Response
    // {
    //     $menuservice = new MenuServices($entityManager);
    //     $retreiveRouteValue = explode("/", $routmenu);
    //     $len = count($retreiveRouteValue);
    //     $name = $menuservice->findMenuByTitle($retreiveRouteValue[$len - 1]);
    //     echo $name[0]->getMenuRoute();

    //     return $this->render('@frontend/home.html.twig', []);
    // }

    #[Route(path: '/services', name: "app_services", methods: ["GET"])]
    public function groupNjService(EntityManagerInterface $entityManager): Response
    {
        $contentsServices = new PageContentsServices($entityManager);
        $menuServices = new MenuServices($entityManager);
        $services = $menuServices->findMenuByTitle("Services");
        $contents = $services[0]->getPagecontents();

        $rslt  = (new DataUtils($entityManager))->getStructuredMenus();
        echo  is_resource($contents->get(0));

        return $this->render('@frontend/groupnj_services.html.twig', ["contents" => $contents, "allMenus" => $rslt]);
    }

    #[Route(path: 'group_nj_services/it_training', name: "app_it_training", methods: ["GET"])]
    public function groupNjService_it_training(EntityManagerInterface $entityManager): Response
    {
        return $this->render('@frontend/it_training.html.twig', []);
    }

    #[Route(path: 'group_nj_services/it_training/orm', name: "app_orm", methods: ["GET"])]
    public function groupNjService_orm(EntityManagerInterface $entityManager): Response
    {
        return $this->render('@frontend/orm.html.twig', []);
    }

    #[Route(path: 'group_nj_services/it_training/app_programming', name: "app_programming", methods: ["GET"])]
    public function groupNjService_programming(EntityManagerInterface $entityManager): Response
    {
        return $this->render('@frontend/app_programming.html.twig', []);
    }

    #[Route(path: 'group_nj_services/project_management', name: "app_projectmanagement", methods: ["GET"])]
    public function groupNjService_projectmanagement(EntityManagerInterface $entityManager): Response
    {
        return $this->render('@frontend/projectmanagement.html.twig', []);
    }


    #[Route(path: 'group_nj_services/transport', name: "app_transport", methods: ["GET"])]
    public function groupNjService_transport(EntityManagerInterface $entityManager): Response
    {
        return $this->render('@frontend/transport.html.twig', []);
    }


    #[Route(path: '/farming', name: "app_farming", methods: ["GET"])]
    public function groupNjService_farming(EntityManagerInterface $entityManager): Response
    {
        $menuServices = new MenuServices($entityManager);
        $services = $menuServices->findMenuByTitle("Farming");
        $aboutnjfarmings = $services[0]->getPagecontents();
        return $this->render('@frontend/farming.html.twig', [
            "allMenus" => (new DataUtils($entityManager))->getStructuredMenus(),
            "aboutnjfarmings" => $aboutnjfarmings
        ]);
    }
    #[Route(path: '/contact', name: "app_contact", methods: ["GET"])]
    public function groupNjService_contact(EntityManagerInterface $entityManager, Request $request, SessionInterface $sessioninterface): Response
    {
        $response = $request->get("response");
        $cssResponse = $request->get("cssResponse");

        $rslt  = (new DataUtils($entityManager))->getStructuredMenus();
        $sessionId = password_hash(strval(random_int(0, 1000000)), PASSWORD_BCRYPT);
        // die($sessionId);
        $sid = $sessioninterface->get("sid");
        if (empty($sid)) {
            $sessioninterface->set('sid', $sessionId);
            $sid = $sessioninterface->get("sid");
        }

        return $this->render('@frontend/contact.html.twig', [
            "allMenus" => $rslt,
            "sid" =>  $sid,
            "cssResponse" =>  $cssResponse,
            "response" => $response
        ]);
    }
    #[Route(path: '/savecontact', name: "app_savecontact", methods: ["POST"])]
    public function groupNjService_sendContact(EntityManagerInterface $entityManager, Request $request): Response
    {
        //$rslt  = (new DataUtils($entityManager))->getStructuredMenus();

        $contastServices = new ContactServices($entityManager);
        $email = $request->request->get("email");
        $description = $request->request->get("desc");
        $name = $request->request->get("name");
        $subject = $request->request->get("subject");
        $phone = $request->request->get("phone");
        $sid = $request->request->get("sid");


        $response = "Send message failed:";
        $cssResponse = "color:#FF8C00; font-size:25px;";
        $existingcontact = ($sid) ? $contastServices->findContactBySid($sid) : null;

        $result = false;

        if ($email && $description && $name && $subject && $phone && empty($existingcontact)) {
            $contact = new Contact();
            $contact->setName($name);
            $contact->setEmail($email);
            $contact->setSubject($subject);
            $contact->setPhone($phone);
            $contact->setDescription($description);
            $contact->setSid($sid);
            $isDescOk = true;
            $isSidOk = true;
            if (strlen($description) > 512) {
                $response = $response . "[ Description is to long - it should contain only 512 characters]";
                $isDescOk = false;
            }
            if (empty($sid)) {
                $response = $response . "-[ Identification code missing]";
                $isSidOk = false;
            }

            if ($isSidOk && $isDescOk) {
                $result = $contastServices->insertContacts($contact);
            }
        }

        if ($existingcontact) {
            $existingcontact->setName($name);
            $existingcontact->setEmail($email);
            $existingcontact->setSubject($subject);
            $existingcontact->setPhone($phone);
            $dscptInsystem = $existingcontact->getDescription();
            $dscpt = $dscptInsystem . $description;
            $existingcontact->setDescription($dscpt);
            if (strlen($dscpt) < 512) {
                $entityManager->flush();
                $result = true;
            } else {
                $response = $response . "[The amount of your remained message description to be sent should contain only  [" . (511 - strlen($dscptInsystem)) . "] characterss]";
            }
        }
        if ($result) {
            $response = "Message sent successfully";
            $cssResponse = "color:green; font-size:25px;";
        }

        return $this->redirectToRoute('app_contact', [
            "cssResponse" =>  $cssResponse,
            "response" => $response
        ]);
    }
}
