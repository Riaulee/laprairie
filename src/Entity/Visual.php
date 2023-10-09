<?php

namespace App\Entity;

use App\Repository\VisualRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Post;

#[ORM\Entity(repositoryClass: VisualRepository::class)]
class Visual
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $visualName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'visuals', cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?post $idPost = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisualName(): ?string
    {
        return $this->visualName;
    }

    public function __toString(): string
    {
        return $this->getVisualName();
    }
    
    public function setVisualName(?string $visualName): static
    {
        $this->visualName = $visualName;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getIdPost(): ?post
    {
        return $this->idPost;
    }

    public function setIdPost(?post $idPost): static
    {
        $this->idPost = $idPost;

        return $this;
    }

}
