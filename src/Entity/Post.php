<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(nullable: true)]
    private ?bool $facebookFlag = null;

    #[ORM\Column(nullable: true)]
    private ?bool $instagramFlag = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $idUser = null;

    #[ORM\OneToMany(mappedBy: 'idPost', targetEntity: Visual::class)]
    private Collection $visuals;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: PostLike::class)]
    private Collection $likes;

    public function __construct()
    {
        $this->visuals = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function isFacebookFlag(): ?bool
    {
        return $this->facebookFlag;
    }

    public function setFacebookFlag(?bool $facebookFlag): static
    {
        $this->facebookFlag = $facebookFlag;

        return $this;
    }

    public function isInstagramFlag(): ?bool
    {
        return $this->instagramFlag;
    }

    public function setInstagramFlag(?bool $instagramFlag): static
    {
        $this->instagramFlag = $instagramFlag;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getIdUser(): ?user
    {
        return $this->idUser;
    }

    public function setIdUser(?user $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * @return Collection<int, Visual>
     */
    public function getVisuals(): Collection
    {
        return $this->visuals;
    }

    public function addVisual(Visual $visual): static
    {
        if (!$this->visuals->contains($visual)) {
            $this->visuals->add($visual);
            $visual->setIdPost($this);
        }

        return $this;
    }

    public function removeVisual(Visual $visual): static
    {
        if ($this->visuals->removeElement($visual)) {
            // set the owning side to null (unless already changed)
            if ($visual->getIdPost() === $this) {
                $visual->setIdPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PostLike>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(PostLike $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setPost($this);
        }

        return $this;
    }

    public function removeLike(PostLike $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getPost() === $this) {
                $like->setPost(null);
            }
        }

        return $this;
    }

    /**
     * Permet de savoir si un évenement est "liké" par un utilisateur
     *
     * @param User $user
     * @return boolean
     */
    public function isLikedByUser(User $user): bool
    {
        foreach ($this->likes as $like) {
            if ($like->getUser() === $user) return true;
        }
        return false;
    }

}
