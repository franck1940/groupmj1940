<?php

namespace App\services\globalsharingservice;

use App\Entity\GlobalSharing;
use App\Entity\User;
use DateTime;

interface IGlSharingServices
{
    public function insertSharingMessage(GlobalSharing $globalSharing): bool;
    public function findSharingMessageByUser(User $user): array;
    public function findSharingMessageById(int $id): GlobalSharing;
    public function findSharingMessageByTitle(string $messageTitle): array;
    public function findSharingMessageByEndDate(DateTime $date): array;
    public function deleteSharingMessageById(int $id): bool;
    public function findAllSharingMessages():array;
}
