<?php

namespace App\services\activityservice;

use App\Entity\Activities;
use App\Entity\User;
use DateTime;

interface IActivityServices
{
    public function insertNewActivity(Activities $activities): bool;
    public function findActivityById(int $id): Activities;
    public function findActivityByUser(User $user): array;
    public function findActivityByTitle(string $title): array;
    public function findActivityByStatus(string $status): array;
    public function findAllActivities(): array;
    public function findActivityByCreateDate(DateTime $createDate): array;
    public function findActivityByEndDate(DateTime $endDate): array;
    public function deleteActivityById(int $id): bool;

}
