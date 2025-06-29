<?php

namespace App\services\globalsharingservice;

use App\Entity\GlobalSharing;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class GlSharingServices implements IGlSharingServices
{

    private EntityManager $entitymanager;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->entitymanager = $em;
    }


    public function insertSharingMessage(GlobalSharing $globalSharing): bool
    {
        try {

            $this->entitymanager->persist($globalSharing);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }

        return true;
    }

    public function findSharingMessageByUser(User $user): array
    {
        return $this->entitymanager->getRepository(GlobalSharing::class)->findBy(["user" => $user]);
    }

    public function findSharingMessageById(int $id): GlobalSharing
    {
        return $this->entitymanager->getRepository(GlobalSharing::class)->find($id);
    }
    public function findSharingMessageByTitle(string $messageTitle): array
    {
        return $this->entitymanager->getRepository(GlobalSharing::class)->findBy(["title" => $messageTitle]);
    }
    public function findSharingMessageByEndDate(DateTime $date): array
    {
        return $this->entitymanager->getRepository(GlobalSharing::class)->findBy(["sharingEndDate" => $date]);
    }
    public function deleteSharingMessageById(int $id): bool
    {
        $tData = $this->findSharingMessageById($id);

        if (!$tData) {
            throw new Exception('No Sharing message found for id ' . $id);
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

    public function findAllSharingMessages(): array
    {
        return $this->entitymanager->getRepository(GlobalSharing::class)->findAll();
    }
}
