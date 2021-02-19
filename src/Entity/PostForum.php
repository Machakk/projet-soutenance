<?php

namespace App\Entity;

use App\Repository\PostForumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostForumRepository::class)
 */
class PostForum
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="postForums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=CommentaireForum::class, mappedBy="post")
     */
    private $commentaireForums;

    /**
     * @ORM\ManyToOne(targetEntity=metiers::class, inversedBy="postForums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $metier;

    public function __construct()
    {
        $this->commentaireForums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

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

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|CommentaireForum[]
     */
    public function getCommentaireForums(): Collection
    {
        return $this->commentaireForums;
    }

    public function addCommentaireForum(CommentaireForum $commentaireForum): self
    {
        if (!$this->commentaireForums->contains($commentaireForum)) {
            $this->commentaireForums[] = $commentaireForum;
            $commentaireForum->setPost($this);
        }

        return $this;
    }

    public function removeCommentaireForum(CommentaireForum $commentaireForum): self
    {
        if ($this->commentaireForums->removeElement($commentaireForum)) {
            // set the owning side to null (unless already changed)
            if ($commentaireForum->getPost() === $this) {
                $commentaireForum->setPost(null);
            }
        }

        return $this;
    }

    public function getMetier(): ?metiers
    {
        return $this->metier;
    }

    public function setMetier(?metiers $metier): self
    {
        $this->metier = $metier;

        return $this;
    }
}
