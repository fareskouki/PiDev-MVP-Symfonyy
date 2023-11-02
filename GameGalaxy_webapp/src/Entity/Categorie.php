<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Nom Obligatoire")]
    /**
     * @Assert\Length(
     *      min = 3,
     *      minMessage=" Entrer un titre au mini de 5 caracteres"
     *
     *     )
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nom_categorie = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"etat Obligatoire")]
    private ?int $etat = null;

    #[ORM\Column(type:"string")]
    #[Assert\NotBlank(message:"type Obligatoire")]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'id_categorie', targetEntity: Produit::class)]
    private Collection $id_categorie;

    private static $typeChoices = [
        '+5ans' => '+5ans',
        '+12ans' => '+12ans',
        '+16ans' => '+16ans',
    ];


    public function __construct()
    {
        $this->id_categorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nom_categorie;
    }

    public function setNomCategorie(string $nom_categorie): self
    {
        $this->nom_categorie = $nom_categorie;

        return $this;
    }

    public function isEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, produit>
     */
    public function getIdCategorie(): Collection
    {
        return $this->id_categorie;
    }

    public function addIdCategorie(produit $idCategorie): self
    {
        if (!$this->id_categorie->contains($idCategorie)) {
            $this->id_categorie->add($idCategorie);
            $idCategorie->setIdCategorie($this);
        }

        return $this;
    }

    public function removeIdCategorie(produit $idCategorie): self
    {
        if ($this->id_categorie->removeElement($idCategorie)) {
            // set the owning side to null (unless already changed)
            if ($idCategorie->getIdCategorie() === $this) {
                $idCategorie->setIdCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNomCategorie();
    }
    
}