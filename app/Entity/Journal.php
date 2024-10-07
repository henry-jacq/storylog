<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'journals')]
class Journal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'string', length: 50)]
    private string $currentMood;

    #[ORM\Column(type: 'string', length: 100)]
    private string $category;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $dateOfJournal;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $location;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'journals')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private User $user;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getCurrentMood(): string
    {
        return $this->currentMood;
    }

    public function setCurrentMood(string $currentMood): self
    {
        $this->currentMood = $currentMood;
        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getDateOfJournal(): \DateTimeInterface
    {
        return $this->dateOfJournal;
    }

    public function setDateOfJournal(\DateTimeInterface $dateOfJournal): self
    {
        $this->dateOfJournal = $dateOfJournal;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
