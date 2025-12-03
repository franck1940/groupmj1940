<?php

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PropertyInfo\Type;

#[ORM\Entity(repositoryClass: ProjectsRepository::class)]
class Projects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'projects')]
    private ?User $user = null;

    #[ORM\Column(length: 200)]
    private ?string $title = null;

    #[ORM\Column(nullable: true, type: types::BLOB)]
    private  $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $createdate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $endDate = null;
    
    private ?string $value = null;
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
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

    public function getDescription(): ?string
    {
       //$str = stream_get_contents($this->description);
        return $this->value;
    }

    public function getDesc(): ?string
    {
        $y = stream_get_contents($this->description);
        echo $y;
        $this->value = $y;
         return "";
    }

    public function setDescription($description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedate()
    {
        return $this->createdate->format('Y-m-d H:i:s');
    }

    public function setCreatedate(\DateTime $createdate): static
    {
        $this->createdate = $createdate;

        return $this;
    }

    /**
     * Get the value of startDate
     */
    public function getStartDate()
    {
        return $this->startDate->format('Y-m-d H:i:s');
    }

    /**
     * Set the value of startDate
     *
     * @return  self
     */
    public function setStartDate(\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the value of endDate
     */
    public function getEndDate()
    {
        return ($this->endDate)->format('Y-m-d H:i:s');
    }

    /**
     * Set the value of endDate
     *
     * @return  self
     */
    public function setEndDate(\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }
}
