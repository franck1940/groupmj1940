<?php
namespace App\services\userrightmanagement;

use App\Entity\Logindata;
use App\Entity\UserRightManagement;

interface IuserRightMgServices
{
    public function insertUserRightMgData(UserRightManagement $userRightManagement): bool;
    public function deleteUserRightMgData(UserRightManagement $userRightManagement): bool;
    public function findUserRightMgDataById(int $id): UserRightManagement;
    public function findUserRightMgDataByLogindata(Logindata $logindata): UserRightManagement;
    public function findAllRightMg():array;
}
?>