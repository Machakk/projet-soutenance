<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 */
class Articles
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
     * @ORM\Column(type="datetime")
     */
    private $date_publication;

    /**
     * @ORM\ManyToOne(targetEntity=Metiers::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $metier;

    /**
     * @ORM\OneToMany(targetEntity=CommentaireArticle::class, mappedBy="article")
     */
    private $commentaireArticles;

    public function __construct()
    {
        $this->commentaireArticles = new ArrayCollection();
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

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->date_publication;
    }

    public function setDatePublication(\DateTimeInterface $date_publication): self
    {
        $this->date_publication = $date_publication;

        return $this;
    }

    public function getMetier(): ?Metiers
    {
        return $this->metier;
    }

    public function setMetier(?Metiers $metier): self
    {
        $this->metier = $metier;

        return $this;
    }

    /**
     * @return Collection|CommentaireArticle[]
     */
    public function getCommentaireArticles(): Collection
    {
        return $this->commentaireArticles;
    }

    public function addCommentaireArticle(CommentaireArticle $commentaireArticle): self
    {
        if (!$this->commentaireArticles->contains($commentaireArticle)) {
            $this->commentaireArticles[] = $commentaireArticle;
            $commentaireArticle->setArticle($this);
        }

        return $this;
    }

    public function removeCommentaireArticle(CommentaireArticle $commentaireArticle): self
    {
        if ($this->commentaireArticles->removeElement($commentaireArticle)) {
            // set the owning side to null (unless already changed)
            if ($commentaireArticle->getArticle() === $this) {
                $commentaireArticle->setArticle(null);
            }
        }

        return $this;
    }
}
