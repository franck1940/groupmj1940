<?php
namespace App\services\contactservice;
use App\Entity\Contact;
use App\services\contactservice\IContactServices;
use Doctrine\ORM\EntityManager;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

class ContactServices implements IContactServices
{
    private EntityManager $em;
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function insertContacts(Contact $contact): bool
    {
        try {

            $this->em->persist($contact);
            $this->em->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }

        return true;
    }
    public function findAllContacts(): array
    {
        return $this->em->getRepository(Contact::class)->findAll();
    }

    public function findContactBySid(string $sid):? Contact
    {
        return $this->em->getRepository(Contact::class)->findOneBy(["sid" => $sid]);
    }

    public function findContactByName(string $personName): array
    {
        return $this->em->getRepository(Contact::class)->findBy(["name" => $personName]);
    }
    public function fincContactByEmail(string $email): array
    {
        return $this->em->getRepository(Contact::class)->findBy(["email" => $email]);
    }
    public function findContactByPhone(int $phone): array
    {
        return $this->em->getRepository(Contact::class)->findBy(["phone" => $phone]);
    }
    public function findContactById(string $id): Contact
    {
        return $this->em->getRepository(Contact::class)->find($id);
    }
    public function removeContactById(int $id):bool
    {

        $tData = $this->findContactById($id);

        if (!$tData) {
            throw new Exception('No Contact found for id ' . $id);
        }

        try {
            $this->em->beginTransaction();
            $this->em->remove($tData);
            $this->em->flush();
            $this->em->commit();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }
        return true;
    }
}
