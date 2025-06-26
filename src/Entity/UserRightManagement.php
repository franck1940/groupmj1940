<?php

namespace App\Entity;

use App\Repository\UserRightManagementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRightManagementRepository::class)]
class UserRightManagement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: Logindata::class, mappedBy: 'userrightmg')]
    private ?Logindata $logindata = null;

    // #[ORM\JoinTable(name: 'user_rights_management')]
    // #[ORM\JoinColumn(name: 'userrightsmg_id', referencedColumnName: 'id')]
    // #[ORM\InverseJoinColumn(name: 'userright_id', referencedColumnName: 'id', unique: true)]
    #[ORM\ManyToMany(targetEntity: UserRights::class)]
    private ?Collection $userRight = null;

    public function __construct()
    {
        $this->userRight = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of userRight
     */
    public function getUserRight(): ?Collection
    {
        return $this->userRight;
    }

    /**
     * Set the value of userRight
     *
     * @return  self
     */
    public function setUserRight(?Collection $userRight): static
    {
        $this->userRight = $userRight;
        return $this;
    }



    /**
     * Get the value of logindata
     */
    public function getLogindata(): ?Logindata
    {
        return $this->logindata;
    }

    /**
     * Set the value of logindata
     *
     * @return  self
     */
    public function setLogindata(?Logindata $logindata)
    {
        $this->logindata = $logindata;

        return $this;
    }
}
