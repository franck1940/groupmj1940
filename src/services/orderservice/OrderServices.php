<?php

namespace App\services\orderservice;

use App\Entity\Orders;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class OrderServices implements IOrderServices
{
    private EntityManager $entitymanager;
    public function __construct(private EntityManagerInterface $em)
    {
        $this->entitymanager = $em;
    }

     public function findAllFarming():array
     {
        return $this->entitymanager->getRepository(Orders::class)->findBy(["serviceName"=>"farming"]);
     }

    public function findtOrderByService(string $serviceName):array
    {
        return $this->entitymanager->getRepository(Orders::class)->findBy(["serviceName"=>$serviceName]);
    }
    public function findOrderById(int $id):Orders
    {
        return $this->entitymanager->getRepository(Orders::class)->find($id);
    }
    public function findOrderByPersonFirstname(string $firstname):array
    {
        return $this->entitymanager->getRepository(Orders::class)->findBy(["firstname"=>$firstname]);
    }
    public function findOrderByPersonLastname(string $lastname):array
    {
        return $this->entitymanager->getRepository(Orders::class)->findBy(["lastname"=>$lastname]);
    }
    public function findOrderByPersonEmail(string $email):array
    {
        return $this->entitymanager->getRepository(Orders::class)->findBy(["email"=>$email]);
    }
    public function findOrderByDate(string $orderDate):array
    {
        return $this->entitymanager->getRepository(Orders::class)->findBy(["orderDate"=>$orderDate]);
    }
    public function findOrderByState(string $state):array
    {
     return $this->entitymanager->getRepository(Orders::class)->findBy(["state"=>$state]);
    }

    public function findAllOrders():array
    {
        return $this->entitymanager->getRepository(Orders::class)->findAll();
    }

}
