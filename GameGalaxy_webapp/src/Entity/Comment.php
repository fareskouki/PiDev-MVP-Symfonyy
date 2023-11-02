<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at=null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?blog $bbid = null;

    #[ORM\ManyToOne(inversedBy: 'id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $iduscomm = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }
 
    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;
 
        return $this;
    }

    public function getBbid(): ?blog
    {
        return $this->bbid;
    }

    public function setBbid(?blog $bbid): self
    {
        $this->bbid = $bbid;
        return $this;
    }

    public function getIduscomm(): ?User
    {
        return $this->iduscomm;
    }

    public function setIduscomm(?User $iduscomm): self
    {
        $this->iduscomm = $iduscomm;

        return $this;
    }

    

}
