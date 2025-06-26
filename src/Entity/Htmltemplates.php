<?php

namespace App\Entity;

use App\Repository\HtmltemplatesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HtmltemplatesRepository::class)]
class Htmltemplates
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 100)]
    private ?string $templateName = null;

    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $createDate = null;

    #[ORM\Column(length: 1)]
    private ?string $FrontOrBackend = null;

    #[ORM\OneToMany(targetEntity: Pagecontents::class, mappedBy: 'htmltemplates')]
    private ?Collection  $pagecontents = null;

     public function __construct()
    {
        $this->pagecontents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemplateName(): ?string
    {
        return $this->templateName;
    }

    public function setTemplateName(string $templateName): static
    {
        $this->templateName = $templateName;

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

    public function getFrontOrBackend(): ?string
    {
        return $this->FrontOrBackend;
    }

    public function setFrontOrBackend(string $FrontOrBackend): static
    {
        $this->FrontOrBackend = $FrontOrBackend;

        return $this;
    }


    /**
     * Get the value of description
     */ 
    public function getDescription():?string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription(?string $description):static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of pagecontents
     */ 
    public function getPagecontents()
    {
        return $this->pagecontents;
    }

    /**
     * Set the value of pagecontents
     *
     * @return  self
     */ 
    public function setPagecontents($pagecontents)
    {
        $this->pagecontents = $pagecontents;

        return $this;
    }
}
