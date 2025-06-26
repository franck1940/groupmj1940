<?php
namespace App\services\userloginservice;
use App\Entity\User;
use App\Entity\Users;

interface IUserLoginServices
{
    public function findUserById(int $id): ?User;
    public function findUserByEmail(string $email): ?User;
    public function findAllUser():array;
    public function insertUser(User $user): ?bool;
    public function deleteUser(int $id):? bool;
    public function findByUsers(Users $user):?User;
}
?>