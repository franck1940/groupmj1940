<?php

namespace App\services\loginservice;

use App\Entity\Logindata;
use App\Entity\Users;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class LoginServices implements IloginServices
{

    private EntityManager $entitymanager;
    public function __construct(private EntityManagerInterface $em)
    {
        $this->entitymanager = $em;
    }


    public function insertLoginUser(Logindata $logindata): bool
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
    public function deleteLoginUser(Logindata $logindata): bool
    {
        $id = $logindata->getId();

        $tData = $this->findLoginUserById($id);

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
    public function findLoginUserById(int $lId):?Logindata
    {
        return $this->entitymanager->getRepository(Logindata::class)->find($lId);
    }
    public function findLoginUserByName(string $lName): array
    {
        $rslt[] = $this->entitymanager->getRepository(Logindata::class)->findOneBy(['loginname' => $lName]);
        return $rslt;
    }
    public function findAllLoginUser(): array
    {
        return $this->entitymanager->getRepository(Logindata::class)->findAll();
    }
}
