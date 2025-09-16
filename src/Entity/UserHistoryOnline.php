<?php

namespace App\Entity;

use App\Repository\UserHistoryOnlineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserHistoryOnlineRepository::class)]
class UserHistoryOnline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userOnline')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $person = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $checkoutDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPerson(): ?object
    {
        return $this->person;
    }

    public function setPerson(object $person): static
    {
        $this->person = $person;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getCheckoutDate(): ?\DateTime
    {
        return $this->checkoutDate;
    }

    public function setCheckoutDate(?\DateTime $checkoutDate): static
    {
        $this->checkoutDate = $checkoutDate;

        return $this;
    }
}
