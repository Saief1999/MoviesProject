<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

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
     * @ORM\Column(type="string", length=50,unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=TblComment::class, mappedBy="user", orphanRemoval=true)
     */
    private $tblComments;

    /**
     * @ORM\OneToMany(targetEntity=CinemaRating::class, mappedBy="user", orphanRemoval=true)
     */
    private $cinemaRatings;

    public function __construct()
    {
        $this->tblComments = new ArrayCollection();
        $this->cinemaRatings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection|TblComment[]
     */
    public function getTblComments(): Collection
    {
        return $this->tblComments;
    }

    public function addTblComment(TblComment $tblComment): self
    {
        if (!$this->tblComments->contains($tblComment)) {
            $this->tblComments[] = $tblComment;
            $tblComment->setUser($this);
        }

        return $this;
    }

    public function removeTblComment(TblComment $tblComment): self
    {
        if ($this->tblComments->contains($tblComment)) {
            $this->tblComments->removeElement($tblComment);
            // set the owning side to null (unless already changed)
            if ($tblComment->getUser() === $this) {
                $tblComment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CinemaRating[]
     */
    public function getCinemaRatings(): Collection
    {
        return $this->cinemaRatings;
    }

    public function addCinemaRating(CinemaRating $cinemaRating): self
    {
        if (!$this->cinemaRatings->contains($cinemaRating)) {
            $this->cinemaRatings[] = $cinemaRating;
            $cinemaRating->setUser($this);
        }

        return $this;
    }

    public function removeCinemaRating(CinemaRating $cinemaRating): self
    {
        if ($this->cinemaRatings->contains($cinemaRating)) {
            $this->cinemaRatings->removeElement($cinemaRating);
            // set the owning side to null (unless already changed)
            if ($cinemaRating->getUser() === $this) {
                $cinemaRating->setUser(null);
            }
        }

        return $this;
    }
}
