<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "Selectionnez un membre!")]
    private ?User $id_membre = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "Selectionnez un évènement!")]
    private ?Evenement $id_evenement = null;


    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdMembre(): ?User
    {
        return $this->id_membre;
    }

    public function setIdMembre(?User $id_membre): self
    {
        $this->id_membre = $id_membre;

        return $this;
    }

    public function getIdEvenement(): ?Evenement
    {
        return $this->id_evenement;
    }

    public function setIdEvenement(?Evenement $id_evenement): self
    {
        $this->id_evenement = $id_evenement;

        return $this;
    }

    

}
