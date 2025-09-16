<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 200)]
    private ?string $menuRoute = null;

    #[ORM\Column(nullable:true)]
    private ?int $parentId = -1;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $createDate ;

    #[ORM\Column(nullable:true)]
    private ?bool $isActive = false;

    #[ORM\OneToMany(targetEntity: Pagecontents::class, mappedBy: 'menu')]
    private ?Collection  $pagecontents = null;

    public function __construct()
    {
        $this->pagecontents = new ArrayCollection();
        $this->createDate= new DateTime(date("Y-m-d"));
        $this->isActive = false;
        $this->parentId = -1;

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCreateDate(): ?\DateTime
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTime $createDate): static
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get the value of pagecontents
     */
    public function getPagecontents(): Collection
    {
        return $this->pagecontents;
    }

    /**
     * Set the value of pagecontents
     *
     * @return  self
     */
    public function setPagecontents(Collection $pagecontents)
    {
        $this->pagecontents = $pagecontents;

        return $this;
    }

    /**
     * Get the value of parentId
     */ 
    public function getParentId():?int
    {
        return $this->parentId;
    }

    /**
     * Set the value of parentId
     *
     * @return  self
     */ 
    public function setParentId(?int $parentId):static
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get the value of menuRoute
     */ 
    public function getMenuRoute()
    {
        return $this->menuRoute;
    }

    /**
     * Set the value of menuRoute
     *
     * @return  self
     */ 
    public function setMenuRoute($menuRoute)
    {
        $this->menuRoute = $menuRoute;

        return $this;
    }
}
