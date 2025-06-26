<?php

namespace App\Entity;

use App\Repository\UserRightsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRightsRepository::class)]
class UserRights
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $rightTitle = null;

    #[ORM\Column(length: 40)]
    private ?string $abbreviation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $CreateDate = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    //#[ORM\ManyToOne(targetEntity: UserRightManagement::class, inversedBy: 'userRight')]
   // private ?UserRightManagement $userRightMg= null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRightTitle(): ?string
    {
        return $this->rightTitle;
    }

    public function setRightTitle(string $rightTitle): static
    {
        $this->rightTitle = $rightTitle;

        return $this;
    }

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): static
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    public function getCreateDate(): ?\DateTime
    {
        return $this->CreateDate;
    }

    public function setCreateDate(?\DateTime $CreateDate): static
    {
        $this->CreateDate = $CreateDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

}
