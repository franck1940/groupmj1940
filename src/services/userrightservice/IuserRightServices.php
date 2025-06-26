<?php

namespace  App\services\userrightservice;

use App\Entity\UserRights;

interface IuserRightServices
{
    public function insertUserRight(UserRights $logindata): bool;
    public function deleteUserRight(UserRights $logindata): bool;
    public function findUserRightById(int $lId): UserRights;
    public function findUserRightByName(string $lName): array;
    public function findAllUserRight(): array;
    public function updateUserRight(UserRights $logindata):bool;
    public function findByAbbreviation(string $abbr):UserRights;
}
?>