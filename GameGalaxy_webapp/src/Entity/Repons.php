<?php

namespace App\Entity;

use App\Repository\ReponsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: ReponsRepository::class)]
class Repons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank (message: "La date est requise!")]
    private ?\DateTimeInterface $date_rep = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank (message: "La description est requise!")]
    #[Assert\Length (max:255)]
    private ?string $contenu_rep = null;

    #[ORM\Column]
    #[Assert\NotBlank (message: "Le status est requise!")]
    private ?int $status_rep = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Reclamation $id_reclamation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRep(): ?\DateTimeInterface
    {
        return $this->date_rep;
    }

    public function setDateRep(\DateTimeInterface $date_rep): self
    {
        $this->date_rep = $date_rep;

        return $this;
    }

    public function getContenuRep(): ?string
    {
        return $this->contenu_rep;
    }

    public function setContenuRep(string $contenu_rep): self
    {
        $this->contenu_rep = $contenu_rep;

        return $this;
    }

    public function getStatusRep(): ?int
    {
        return $this->status_rep;
    }

    public function setStatusRep(int $status_rep): self
    {
        $this->status_rep = $status_rep;

        return $this;
    }

    public function getIdReclamation(): ?Reclamation
    {
        return $this->id_reclamation;
    }

    public function setIdReclamation(?Reclamation $id_reclamation): self
    {
        $this->id_reclamation = $id_reclamation;

        return $this;
    }
}
