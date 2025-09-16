<?php

namespace App\Entity;

use App\Repository\PagecontentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PagecontentsRepository::class)]
class Pagecontents
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 2048, nullable: true)]
    private ?string $contentText = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $picture;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $createDate = null;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: "pagecontents")]
    private ?Menu $menu = null;

    #[ORM\ManyToOne(targetEntity: Htmltemplates::class, inversedBy: "pagecontents")]
    //  #[ORM\JoinColumn(name: 'htmlpage_id', referencedColumnName: 'id', nullable:true)]
    private ?Htmltemplates $contentTemplate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable:true)]
    private ?\DateTime $expiredDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentText(): ?string
    {
        return $this->contentText;
    }

    public function setContentText(?string $contenttext): static
    {
        $this->contentText = $contenttext;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

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


    /**
     * Get the value of contentTemplate
     */
    public function getContentTemplate(): ?Htmltemplates
    {
        return $this->contentTemplate;
    }

    /**
     * Set the value of contentTemplate
     *
     * @return  self
     */
    public function setContentTemplate(Htmltemplates $contentTemplate)
    {
        $this->contentTemplate = $contentTemplate;

        return $this;
    }

    /**
     * Get the value of menu
     */
    public function getMenu(): Menu
    {
        return $this->menu;
    }

    /**
     * Set the value of menu
     *
     * @return  self
     */
    public function setMenu(Menu $menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }



    /**
     * Get the value of expiredDate
     */ 
    public function getExpiredDate()
    {
        return $this->expiredDate;
    }

    /**
     * Set the value of expiredDate
     *
     * @return  self
     */ 
    public function setExpiredDate($expiredDate)
    {
        $this->expiredDate = $expiredDate;

        return $this;
    }
}
