<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fichier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linksite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkgit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkfacebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imgprofil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Skills::class, mappedBy="user")
     */
    private $skills;

    /**
     * @ORM\OneToMany(targetEntity=PostForum::class, mappedBy="user", orphanRemoval=true)
     */
    private $postForums;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->postForums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(?string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getLinksite(): ?string
    {
        return $this->linksite;
    }

    public function setLinksite(?string $linksite): self
    {
        $this->linksite = $linksite;

        return $this;
    }

    public function getLinkgit(): ?string
    {
        return $this->linkgit;
    }

    public function setLinkgit(?string $linkgit): self
    {
        $this->linkgit = $linkgit;

        return $this;
    }

    public function getLinkfacebook(): ?string
    {
        return $this->linkfacebook;
    }

    public function setLinkfacebook(?string $linkfacebook): self
    {
        $this->linkfacebook = $linkfacebook;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getImgprofil(): ?string
    {
        return $this->imgprofil;
    }

    public function setImgprofil(?string $imgprofil): self
    {
        $this->imgprofil = $imgprofil;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Skills[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skills $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->addUser($this);
        }

        return $this;
    }

    public function removeSkill(Skills $skill): self
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeUser($this);
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
            $postForum->setUser($this);
        }

        return $this;
    }

    public function removePostForum(PostForum $postForum): self
    {
        if ($this->postForums->removeElement($postForum)) {
            // set the owning side to null (unless already changed)
            if ($postForum->getUser() === $this) {
                $postForum->setUser(null);
            }
        }

        return $this;
    }
}
