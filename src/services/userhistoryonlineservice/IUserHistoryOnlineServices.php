<?php
namespace App\services\userhistoryonlineservice;

use App\Entity\User;
use App\Entity\UserHistoryOnline;
use DateTime;

interface IUserHistoryOnlineServices{
    public function insertUserHistoryOnline(UserHistoryOnline $userHistoryOnline):bool;
    public function findUserHistoryOnlineById(int $id):UserHistoryOnline;
    public function findUserHistoryOnlineByStartDate(DateTime $date):array;
    public function findUserHistoryOnlineByCheckoutDate(DateTime $checkoutDate):array;
    public function findUserHistoryOnlineByUser(User $user):array;
    public function findAllUserHistoryOnline():array;
    public function deleteUserHistoryOnlineById(int $id):bool;
}
?>