<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClubRepository::class)]
class Club
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column]
    private ?int $Members = null;

    #[ORM\Column(length: 255)]
    private ?string $President = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Foundation = null;

    #[ORM\Column(length: 255)]
    private ?string $status = "Active";

    #[ORM\Column(length: 255)]
    private ?string $image = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getMembers(): ?int
    {
        return $this->Members;
    }

    public function setMembers(int $Members): static
    {
        $this->Members = $Members;

        return $this;
    }

    public function getPresident(): ?string
    {
        return $this->President;
    }

    public function setPresident(string $President): static
    {
        $this->President = $President;

        return $this;
    }

    public function getFoundation(): ?\DateTimeInterface
    {
        return $this->Foundation;
    }

    public function setFoundation(\DateTimeInterface $Foundation): static
    {
        $this->Foundation = $Foundation;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

}
