<?php

namespace App\Controller;

use App\services\orderservice\OrderServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrdersController extends AbstractController
{

    #[Route(path: "/backendmanagement/ordermanagement/allorders", name: "allorders")]
    public function showAllOrders(EntityManagerInterface $entityManager): Response
    {
        $orderService = new OrderServices($entityManager);
        $allOrder = $orderService->findAllOrders();
        return   $this->render('@backend/allOrders.html.twig', ["value" => "Client orders", "allOrders" => $allOrder]);
    }

     #[Route(path: "/backendmanagement/ordermanagement/serveiceOrderForm", name: "serveiceOrderForm")]
    public function handlingServiceOrders(EntityManagerInterface $entityManager): Response
    {
        $orderService = new OrderServices($entityManager);
        $allOrder = $orderService->findAllOrders();
        return   $this->render('@backend/allOrders.html.twig', ["value" => "Client orders", "allOrders" => $allOrder]);
    }
}
