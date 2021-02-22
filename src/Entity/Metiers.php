<?php

namespace App\Entity;

use App\Entity\Users;
use App\Entity\Articles;
use App\Entity\PostForum;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MetiersRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=MetiersRepository::class)
 */
class Metiers
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
    private $metier;

    /**
     * @ORM\OneToMany(targetEntity=Users::class, mappedBy="metier")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Articles::class, mappedBy="metier")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=PostForum::class, mappedBy="metier")
     */
    private $postForums;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->postForums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMetier(): ?string
    {
        return $this->metier;
    }

    public function setMetier(string $metier): self
    {
        $this->metier = $metier;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setMetier($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getMetier() === $this) {
                $user->setMetier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Articles[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setMetier($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getMetier() === $this) {
                $article->setMetier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PostForum[]
     */
    public function getPostForums(): Collection
    {
        return $this->postForums;
    }

    public function addPostForum(PostForum $postForum): self
    {
        if (!$this->postForums->contains($postForum)) {
            $this->postForums[] = $postForum;
            $postForum->setMetier($this);
        }

        return $this;
    }

    public function removePostForum(PostForum $postForum): self
    {
        if ($this->postForums->removeElement($postForum)) {
            // set the owning side to null (unless already changed)
            if ($postForum->getMetier() === $this) {
                $postForum->setMetier(null);
            }
        }

        return $this;
    }
}
