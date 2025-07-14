<?php

namespace App\services\userhistoryonlineservice;

use App\Entity\User;
use App\Entity\UserHistoryOnline;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UserHistoryOnlineServices implements IUserHistoryOnlineServices
{
    private EntityManager $entitymanager;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->entitymanager = $em;
    }

    public function insertUserHistoryOnline(UserHistoryOnline $userHistoryOnline): bool
    {
        try {

            $this->entitymanager->persist($userHistoryOnline);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }

        return true;
    }
    public function findUserHistoryOnlineById(int $id): UserHistoryOnline
    {
        return $this->entitymanager->getRepository(UserHistoryOnline::class)->find($id);
    }
    public function findUserHistoryOnlineByStartDate(DateTime $date): array
    {
        return $this->entitymanager->getRepository(UserHistoryOnline::class)->findBy(["startDate" => $date,"checkoutDate"=>null]);
    }
    public function findUserHistoryOnlineByCheckoutDate(DateTime $checkoutDate): array
    {
        return $this->entitymanager->getRepository(UserHistoryOnline::class)->findBy(["checkoutDate" => $checkoutDate]);
    }
    public function findUserHistoryOnlineByUser(User $user): array
    {
        return $this->entitymanager->getRepository(UserHistoryOnline::class)->findBy(["person" => $user, "checkoutDate"=>null]);
    }
    public function findAllUserHistoryOnline(): array
    {
        return $this->entitymanager->getRepository(UserHistoryOnline::class)->findAll();
    }
    public function deleteUserHistoryOnlineById(int $id): bool
    {
        $tData = $this->findUserHistoryOnlineById($id);

        if (!$tData) {
            throw new Exception('No user history user found for id ' . $id);
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
