<?php

namespace App\services\logindataservice;

use App\Entity\Logindata;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class LoginDataServices implements IloginDataServices
{

    private EntityManager $entitymanager;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->entitymanager = $em;
    }

    public function insertLoginData(Logindata $logindata): bool
    {
        try {

            $this->entitymanager->persist($logindata);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }

        return true;
    }
    public function updateLoginData(Logindata $logindata): bool
    {
        $id = $logindata->getId();

        $tData = $this->findById($id);

        if (!$tData) {
            throw new Exception('No product found for id ' . $id);
        }

        try {
            $this->entitymanager->beginTransaction();
            $this->entitymanager->remove($tData);
            $this->entitymanager->flush();
            $this->entitymanager->commit();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }
        return true;
    }
    public function findById(int $id):?Logindata
    {
        return $this->entitymanager->getRepository(Logindata::class)->find($id);
    }
    public function findByloginname(string $name): ?Logindata
    {
        return $this->entitymanager->getRepository(Logindata::class)->findOneBy(["loginname" => $name]);
    }
    public function findByUserId(int $userId): ?Logindata
    {

        return $this->entitymanager->getRepository(Logindata::class)->findOneBy(["userId" => $userId]);
    }
    public function findByUserMgId(int $userRtMgId): ?Logindata
    {
        return $this->entitymanager->getRepository(Logindata::class)->findOneBy(["userRightManagementId" => $userRtMgId]);
    }
    public function deleteLogindata(Logindata $logindata): bool
    {

        try {
            $this->entitymanager->beginTransaction();
            $this->entitymanager->flush();
            $this->entitymanager->commit();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }
        return true;
    }

    public function findAllLogindata(): array
    {
        return $this->entitymanager->getRepository(Logindata::class)->findAll();
    }
}
