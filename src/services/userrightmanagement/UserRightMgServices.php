<?php

namespace App\services\userrightmanagement;

use App\Entity\Logindata;
use App\Entity\UserRightManagement;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UserRightMgServices implements IuserRightMgServices
{
    private EntityManager $entitymanager;
    public function __construct(
        private EntityManagerInterface $em
    ) {
        $this->entitymanager = $em;
    }
    public function insertUserRightMgData(UserRightManagement $userRightManagement): bool
    {
        try {

            $this->entitymanager->persist($userRightManagement);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);

            return false;
        }

        return true;
    }

    public function deleteUserRightMgData(UserRightManagement $userRightManagement): bool
    {
        $user = $this->findUserRightMgDataById($userRightManagement->getId());

        if (!$user) {
            throw new Exception('No product found for id ' . $userRightManagement);
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
    public function findUserRightMgDataById(int $id): UserRightManagement
    {
        return $this->entitymanager->getRepository(UserRightManagement::class)->find($id);
    }

    public function findAllRightMg(): array
    {
        return  $this->entitymanager->getRepository(UserRightManagement::class)->findAll();
    }

    public function findUserRightMgDataByLogindata(Logindata $logindata): UserRightManagement
    {
        return $this->entitymanager->find("Logindata", $logindata->getId());
    }
}
