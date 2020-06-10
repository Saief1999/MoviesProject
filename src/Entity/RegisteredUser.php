<?php

namespace App\Entity;

use App\Repository\RegisteredUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RegisteredUserRepository::class)
 */
class RegisteredUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     *
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=MovieGenre::class)
     */
    private $favoriteGenres;

    public function __construct()
    {
        $this->favoriteGenres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|MovieGenre[]
     */
    public function getFavoriteGenres(): Collection
    {
        return $this->favoriteGenres;
    }

    public function addFavoriteGenre(MovieGenre $favoriteGenre): self
    {
        if (!$this->favoriteGenres->contains($favoriteGenre)) {
            $this->favoriteGenres[] = $favoriteGenre;
        }

        return $this;
    }

    public function removeFavoriteGenre(MovieGenre $favoriteGenre): self
    {
        if ($this->favoriteGenres->contains($favoriteGenre)) {
            $this->favoriteGenres->removeElement($favoriteGenre);
        }

        return $this;
    }
}
