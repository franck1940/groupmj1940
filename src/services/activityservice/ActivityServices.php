<?php

namespace App\services\activityservice;

use App\Entity\Activities;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class ActivityServices implements IActivityServices
{
    private EntityManager $entitymanager;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->entitymanager = $em;
    }

    public function insertNewActivity(Activities $activities): bool
    {
        try {

            $this->entitymanager->persist($activities);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }

        return true;
    }

    public function findActivityById(int $id): Activities
    {
        return $this->entitymanager->getRepository(Activities::class)->find($id);
    }

    public function findActivityByUser(User $user): array
    {
        return $this->entitymanager->getRepository(Activities::class)->findBy(["user" => $user]);
    }
    public function findActivityByTitle(string $title): array
    {
        return $this->entitymanager->getRepository(Activities::class)->findBy(["acTitle" => $title]);
    }
    public function findActivityByStatus(string $status): array
    {
        return $this->entitymanager->getRepository(Activities::class)->findBy(["status" => $status]);
    }
    public function findAllActivities(): array
    {
        return $this->entitymanager->getRepository(Activities::class)->findAll();
    }
    public function findActivityByCreateDate(DateTime $createDate): array
    {
        return $this->entitymanager->getRepository(Activities::class)->findBy(["createDate" => $createDate]);
    }
    public function findActivityByEndDate(DateTime $endDate): array
    {
        return $this->entitymanager->getRepository(Activities::class)->findBy(["endDate" => $endDate]);
    }
    public function deleteActivityById(int $id): bool
    {

        $tData = $this->findActivityById($id);

        if (!$tData) {
            throw new Exception('No activity found for id ' . $id);
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
}
