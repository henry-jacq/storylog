<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity, ORM\Table(name: 'users')]
class User
{
    #[ORM\Id, ORM\Column(type: 'integer', options: ['unsigned' => true]), ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', unique: true)]
    private string $username;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'integer')]
    private int $active;

    #[ORM\Column(type: 'integer', name: 'pass_code', nullable: true)]
    private ?string $passCode;

    #[ORM\Column(type: 'datetime', name: 'created_at')]
    private \DateTime $createdAt;

    #[ORM\Column(type: 'string', name: 'reset_token', nullable: true)]
    private ?string $resetToken;

    #[ORM\Column(type: 'datetime', name: 'reset_token_expiry', nullable: true)]
    private ?\DateTime $resetTokenExpiry;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->following = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->storage = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function getPassCode(): int
    {
        return $this->passCode;
    }

    public function setPassCode(int $passCode): self
    {
        $this->passCode = $passCode;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;
        return $this;
    }

    public function getResetTokenExpiry(): ?\DateTime
    {
        return $this->resetTokenExpiry;
    }

    public function setResetTokenExpiry(?\DateTime $resetTokenExpiry): self
    {
        $this->resetTokenExpiry = $resetTokenExpiry;
        return $this;
    }
}
