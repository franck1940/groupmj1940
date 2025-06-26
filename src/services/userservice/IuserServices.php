<?php
namespace App\services\userservice;
use App\Entity\Users;

interface IuserServices
{

    public function insertUser(Users $user): bool;
    public function findUserById(int $id): Users;
    public function findUserByName(string $firstname): Users;
    public function findUserByLastname(string $lastname): Users;
    public function findUsertByStreetName(string $strname): array;
    public function findUsertByStreetNumber(string $strnumber): array;
    public function findUsertByPhoneNumber(string $phoneNumber): array;
    public function findUserByBirthday(string $date): array;
    public function deleteUser(int $userId): bool;
    public function updateUser(Users $user): bool;
    public function findAllUser(): array;
    public function findUserByEmail(string $email): array;
}
