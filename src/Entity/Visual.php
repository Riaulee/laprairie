<?php

namespace App\Entity;

use App\Repository\VisualRepository;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\ManyToOne(inversedBy: 'visuals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?event $idEvent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisualName(): ?string
    {
        return $this->visualName;
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

    public function getIdEvent(): ?event
    {
        return $this->idEvent;
    }

    public function setIdEvent(?event $idEvent): static
    {
        $this->idEvent = $idEvent;

        return $this;
    }
}
