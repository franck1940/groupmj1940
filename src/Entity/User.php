<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Scheb\TwoFactorBundle\Model\Totp\TotpConfiguration;
use Scheb\TwoFactorBundle\Model\Totp\TotpConfigurationInterface;
use Scheb\TwoFactorBundle\Model\Totp\TwoFactorInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface, TwoFactorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\ManyToMany(targetEntity: UserRights::class)]
    private ?Collection $userRight = null;

    #[ORM\OneToOne(targetEntity: Users::class, inversedBy: 'user', fetch: 'EXTRA_LAZY')]
    private ?Users $users = null;

    #[ORM\OneToMany(targetEntity: UserHistoryOnline::class, mappedBy: 'person')]
    private ?Collection $userOnline = null;

    #[ORM\OneToMany(targetEntity: Activities::class, mappedBy: 'user')]
    private ?Collection $activities = null;

    #[ORM\OneToMany(targetEntity: GlobalSharing::class, mappedBy: 'user')]
    private ?Collection $globalsharing = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    #[ORM\Column(type: "string", nullable: true)]
    private ?string $totpSecret;

    public function __construct()
    {
        $this->userRight = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->userOnline = new ArrayCollection();
        $this->globalsharing = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
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
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Get the value of userRight
     */
    public function getUserRight(): Collection
    {
        return $this->userRight;
    }

    /**
     * Set the value of userRight
     *
     * @return  self
     */
    public function setUserRight(Collection $userRight): static
    {
        $this->userRight = $userRight;

        return $this;
    }

    /**
     * Get the value of users
     */
    public function getUsers(): Users
    {
        return $this->users;
    }

    /**
     * Set the value of users
     *
     * @return  self
     */
    public function setUsers(Users $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function isTotpAuthenticationEnabled(): bool
    {
        return $this->totpSecret ? true : false;
    }

    public function getTotpAuthenticationUsername(): string
    {
        return $this->email;
    }

    public function getTotpAuthenticationConfiguration(): ?TotpConfigurationInterface
    {
        // You could persist the other configuration options in the user entity to make it individual per user.
        return new TotpConfiguration($this->totpSecret, TotpConfiguration::ALGORITHM_SHA1, 30, 6);
    }

    public function getTotpSecret(): ?string
    {
        return $this->totpSecret;
    }
    public function setTotpSecret(?string $totpSecret): self
    {
        $this->totpSecret = $totpSecret;
        return $this;
    }

    /**
     * Get the value of userOnline
     */
    public function getUserOnline(): ?UserHistoryOnline
    {
        return $this->userOnline;
    }

    /**
     * Set the value of userOnline
     *
     * @return  self
     */
    public function setUserOnline(?UserHistoryOnline $userOnline): static
    {
        $this->userOnline = $userOnline;

        return $this;
    }


    /**
     * Get the value of activities
     */
    public function getActivities(): ?Collection
    {
        return $this->activities;
    }

    /**
     * Set the value of activities
     *
     * @return  self
     */
    public function setActivities(?Collection $activities)
    {
        $this->activities = $activities;

        return $this;
    }

    /**
     * Get the value of globalsharing
     */
    public function getGlobalsharing()
    {
        return $this->globalsharing;
    }

    /**
     * Set the value of globalsharing
     *
     * @return  self
     */
    public function setGlobalsharing($globalsharing)
    {
        $this->globalsharing = $globalsharing;

        return $this;
    }
}
