<?php

namespace App\Entity;

use App\Repository\LogindataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogindataRepository::class)]
class Logindata
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $loginname = null;

    #[ORM\Column(length: 200)]
    private ?string $password = null;


    #[ORM\OneToOne(targetEntity: Users::class, inversedBy: 'logindata')]
    private ?Users $users = null;

    #[ORM\OneToOne(targetEntity: UserRightManagement::class, inversedBy: 'logindata')]
    private ?UserRightManagement $userrightmg = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getLoginname(): ?string
    {
        return $this->loginname;
    }

    public function setLoginname(string $loginname): static
    {
        $this->loginname = $loginname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }


    /**
     * Get the value of users
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set the value of users
     *
     * @return  self
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get the value of userrightmg
     */ 
    public function getUserrightmg()
    {
        return $this->userrightmg;
    }

    /**
     * Set the value of userrightmg
     *
     * @return  self
     */ 
    public function setUserrightmg($userrightmg)
    {
        $this->userrightmg = $userrightmg;

        return $this;
    }
}
