<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message: "Le nom est requis!")]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank (message: "La date est requise!")]
    private ?\DateTimeInterface $date = null;

    
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank (message: "La description est requise!")]
    #[Assert\Length (max:65535)]
    private ?string $description = null;

    
    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank (message: "La durée est requise!")]
    private ?int $duree = null;
    
    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank (message: "La capacité est requise!")]
    #[Assert\Positive()]
    private ?int $capacite = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank (message: "Le type est requis!")]
    #[Assert\Length (max:255)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(?int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }


    public function __toString()
    {
        return $this->getNom() . ' (' . $this->getDate()->format('Y M l H:i:s') . ') '
        ;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }
}
