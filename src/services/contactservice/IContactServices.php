<?php

namespace App\services\contactservice;

use App\Entity\Contact;

interface IContactServices
{
    public function insertContacts(Contact $contact): bool;
    public function findAllContacts(): array;
    public function findContactById(string $sid): ?Contact;
    public function findContactBySid(string $sid): ?Contact;
    public function findContactByName(string $personName): array;
    public function fincContactByEmail(string $email): array;
    public function findContactByPhone(int $phone);
    public function removeContactById(int $id):bool;
}
