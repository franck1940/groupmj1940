<?php
namespace App\services\logindataservice;

use App\Entity\Logindata;

interface IloginDataServices{
    public function insertLoginData(Logindata $logindata):bool;
    public function updateLoginData(Logindata $logindata):bool;
    public function findById(int $id):?Logindata;
    public function findByloginname(string $name):?Logindata;
    public function findByUserId(int $id):?Logindata;
    public function findByUserMgId(int $id):?Logindata;
    public function deleteLogindata(Logindata $logindata):bool;
    public function findAllLogindata():array;
}
?>