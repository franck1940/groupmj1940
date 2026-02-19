<?php
namespace App\services\orderservice;

use App\Entity\Orders;

interface IOrderServices{
    public function findAllFarming():array;
    public function findtOrderByService(string $serviceName):array;
    public function findOrderById(int $id):Orders;
    public function findOrderByPersonFirstname(string $name):array;
    public function findOrderByPersonLastname(string $name):array;
    public function findOrderByPersonEmail(string $email):array;
    public function findOrderByDate(string $orderDate):array;
    public function findOrderByState(string $state):array;
    public function findAllOrders():array;
}
?>