<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $session = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'carts',cascade: ["persist"])]
    private Collection $id_pproduct;

    public function __construct()
    {
        $this->id_pproduct = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSession(): ?string
    {
        return $this->session;
    }

    public function setSession(string $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getIdPproduct(): Collection
    {
        return $this->id_pproduct;
    }

    public function addIdPproduct(Produit $idPproduct): self
    {
        if (!$this->id_pproduct->contains($idPproduct)) {
            $this->id_pproduct->add($idPproduct);
        }

        return $this;
    }

    public function removeIdPproduct(Produit $idPproduct): self
    {
        $this->id_pproduct->removeElement($idPproduct);

        return $this;
    }
}
