<?php

namespace App\services\userloginservice;

use App\Entity\User;
use App\Entity\Users;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UserLoginServices implements IUserLoginServices
{
    private EntityManager $entitymanager;
    public function __construct(private EntityManagerInterface $em)
    {
        $this->entitymanager = $em;
    }

    public function findUserById(int $id): ?User
    {
        return  $this->entitymanager->getRepository(User::class)->find($id);
    }
    public function findAllUser(): array
    {
        return  $this->entitymanager->getRepository(User::class)->findAll();
    }
    
    public function insertUser(User $user): ?bool
    {
        try {

            $this->entitymanager->persist($user);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }

        return true;
    }

    public function deleteUser(int $id): ?bool
    {

        $user = $this->findUserById($id);

        if (!$user) {
            throw new Exception('No product found for id ' . $id);
        }

        try {
            $this->entitymanager->beginTransaction();
            $this->entitymanager->remove($user);
            $this->entitymanager->flush();
            $this->entitymanager->commit();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }
        return true;
    }

    public function findUserByEmail(string $email):?User{
        return$this->entitymanager->getRepository(User::class)->findOneBy(['email' => $email]);
    }
    
    public function findByUsers(Users $user) : ?User
    {
     return $this->entitymanager->getRepository(User::class)->findOneBy(["users"=> $user]);
    }
}
