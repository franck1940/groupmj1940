<?php

namespace App\services\userservice;

use App\Entity\Users;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UserServices implements IuserServices
{
    private EntityManager $entitymanager;
    public function __construct(
        private EntityManagerInterface $em
    ) {
        $this->entitymanager = $em;
    }
    public function insertUser(Users $user): bool
    {
        try {

            $this->entitymanager->persist($user);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);

            return false;
        }

        return true;
    }
    public function findUserByName(string $firstname): Users
    {
        $user =  $this->entitymanager->getRepository(Users::class)->findOneBy(['firstname' => $firstname]);
        return $user;
    }
    public function findUserByLastname(string $lastname): Users
    {
        $user =  $this->entitymanager->getRepository(Users::class)->findOneBy(['lastname' => $lastname]);
        return $user;
    }
    public function findUsertByStreetName(string $strname): array
    {
        $rslt[] = $this->entitymanager->getRepository(Users::class)->findOneBy(['streetName' => $strname]);

        return $rslt;
    }
    public function findUsertByStreetNumber(string $strnumber): array
    {
        $rslt[] = $this->entitymanager->getRepository(Users::class)->findOneBy(['streetNumber' => $strnumber]);
        return $rslt;
    }
    public function findUsertByPhoneNumber(string $phoneNumber): array
    {
        $rslt[] = $this->entitymanager->getRepository(Users::class)->findOneBy(['phoneNumber' => $phoneNumber]);
        return $rslt;
    }
    public function findUserByBirthday(string $date): array
    {
        $rslt[] = $this->entitymanager->getRepository(Users::class)->findOneBy(['birthday' => $date]);
        return $rslt;
    }

    public function findAllUser(): array
    {
        return $this->entitymanager->getRepository(Users::class)->findAll();
    }

    public function findUserById(int $id): Users
    {
        return $this->entitymanager->getRepository(Users::class)->find($id);
    }

    public function deleteUser(int $userId): bool
    {
        $user = $this->findUserById($userId);

        if (!$user) {
            throw new Exception('No product found for id ' . $userId);
        }

        try {
            $this->entitymanager->beginTransaction();

            $this->entitymanager->remove($user);
            $this->entitymanager->flush();
            $this->entitymanager->commit();
        } catch (Exception $ex) {
            throw new Exception($ex);

            return false;
        }

        return true;
    }

    public function updateUser(Users $user): bool
    {
        $this->entitymanager->persist($user);
        $this->entitymanager->flush();
        return true;
    }

    public function findUserByEmail(string $email): array
    {
        $rslt[] = $this->entitymanager->getRepository(Users::class)->findOneBy(['email' => $email]);
        return $rslt;
     }

    public function findUserByBirtday(string $date): array
    {
        $rslt[] = null;
        return $rslt;
    }
}
