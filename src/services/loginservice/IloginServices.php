<?php
namespace App\services\loginservice;
use App\Entity\Logindata;

interface IloginServices{
    public function insertLoginUser(Logindata $logindata): bool;
    public function deleteLoginUser(Logindata $logindata): bool;
    public function findLoginUserById(int $lId):?Logindata;
    public function findLoginUserByName(string $lName):array;
    public function findAllLoginUser():array;
}
?>