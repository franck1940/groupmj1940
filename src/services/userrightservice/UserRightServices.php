<?php

namespace App\services\userrightservice;

use App\Entity\UserRights;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UserRightServices implements IuserRightServices
{
    private EntityManager $entitymanager;
    public function __construct(private EntityManagerInterface $em)
    {
        $this->entitymanager = $em;
    }

    public function insertUserRight(UserRights $userRights): bool
    {
        try {

            $this->entitymanager->persist($userRights);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }

        return true;
    }
    public function deleteUserRight(int $id): bool
    {

        $tData = $this->findUserRightById($id);

        if (!$tData) {
            throw new Exception('No right found for id ' . $id);
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
    public function findUserRightById(int $id): UserRights
    {
        return $this->entitymanager->getRepository(UserRights::class)->find($id);
    }
    public function findUserRightByName(string $userRtitle): array
    {
        $rslt[] = $this->entitymanager->getRepository(UserRights::class)->findOneBy(['rightTitle' => $userRtitle]);
        return $rslt;
    }
    public function findAllUserRight(): array
    {
        return $this->entitymanager->getRepository(UserRights::class)->findAll();
    }
    public function  updateUserRight(UserRights $userRights): bool
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

    public function findByAbbreviation(string $abbr): UserRights
    {

        return $this->entitymanager->getRepository(UserRights::class)->findOneBy(['abbreviation' => $abbr]);
    }
}
