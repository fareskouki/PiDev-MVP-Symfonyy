<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\JoinColumn;
#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message: "Le titre est requis!")]
    private ?string $titre_rec = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message: "Le type est requis!")]
    private ?string $type_rec = null;
   
    #[assert\Range(min: 'now',)]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank (message: "La date est requise!")]
    private ?\DateTimeInterface $date_rec = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank (message: "La description est requise!")]
    #[Assert\Length (max:255)]
    private ?string $contenu_rec = null;

    #[ORM\Column]
    #[Assert\NotBlank (message: "Le status est requise!")]
    #[Assert\Choice(choices: [1, 2, 3])]
    private ?int $statut_rec = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message: "User Name est requise!")]
    private ?string $username = null;

    #[ORM\ManyToOne(inversedBy: 'items', cascade: ["persist"])]
    private ?Order $commande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreRec(): ?string
    {
        return $this->titre_rec;
    }

    public function setTitreRec(string $titre_rec): self
    {
        $this->titre_rec = $titre_rec;

        return $this;
    }

    public function getTypeRec(): ?string
    {
        return $this->type_rec;
    }

    public function setTypeRec(string $type_rec): self
    {
        $this->type_rec = $type_rec;

        return $this;
    }

    public function getDateRec(): ?\DateTimeInterface
    {
        return $this->date_rec;
    }

    public function setDateRec(\DateTimeInterface $date_rec): self
    {
        $this->date_rec = $date_rec;

        return $this;
    }

    public function getContenuRec(): ?string
    {
        return $this->contenu_rec;
    }

    public function setContenuRec(string $contenu_rec): self
    {
        $this->contenu_rec = $contenu_rec;

        return $this;
    }

    public function getStatutRec(): ?int
    {
        return $this->statut_rec;
    }

    public function setStatutRec(int $statut_rec): self
    {
        $this->statut_rec = $statut_rec;

        return $this;
    }
    public function __toString()
    {
        return $this->getUsername();
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    
    public function getCommande(): ?Order
    {
        return $this->commande;
    }

    public function setCommande(?Order $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
}
