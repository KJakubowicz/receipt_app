<?php

namespace App\Entity;

use App\Repository\FriendsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FriendsRepository::class)]
class Friends
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_owner = null;

    #[ORM\Column]
    private ?int $id_user = null;

    #[ORM\Column]
    private ?bool $confirmed = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $last_modification = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdOwner(): ?int
    {
        return $this->id_owner;
    }

    public function setIdOwner(int $id_owner): self
    {
        $this->id_owner = $id_owner;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function isConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLastModification(): ?\DateTimeImmutable
    {
        return $this->last_modification;
    }

    public function setLastModification(?\DateTimeImmutable $last_modification): self
    {
        $this->last_modification = $last_modification;

        return $this;
    }
}
