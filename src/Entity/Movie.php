<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $plot;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tmdbLink;

    /**
     * @ORM\OneToMany(targetEntity=MoviePlanning::class, mappedBy="movie", orphanRemoval=true)
     */
    private $moviePlannings;

    /**
     * @ORM\ManyToMany(targetEntity=MovieGenre::class)
     */
    private $genres;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imdbLink;

    public function __construct()
    {
        $this->moviePlannings = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->plot;
    }

    public function setPlot(?string $plot): self
    {
        $this->plot = $plot;

        return $this;
    }

    public function getTmdbLink(): ?string
    {
        return $this->tmdbLink;
    }

    public function setTmdbLink(?string $tmdbLink): self
    {
        $this->tmdbLink = $tmdbLink;

        return $this;
    }

    /**
     * @return Collection|MoviePlanning[]
     */
    public function getMoviePlannings(): Collection
    {
        return $this->moviePlannings;
    }

    public function addMoviePlanning(MoviePlanning $moviePlanning): self
    {
        if (!$this->moviePlannings->contains($moviePlanning)) {
            $this->moviePlannings[] = $moviePlanning;
            $moviePlanning->setMovie($this);
        }

        return $this;
    }

    public function removeMoviePlanning(MoviePlanning $moviePlanning): self
    {
        if ($this->moviePlannings->contains($moviePlanning)) {
            $this->moviePlannings->removeElement($moviePlanning);
            // set the owning side to null (unless already changed)
            if ($moviePlanning->getMovie() === $this) {
                $moviePlanning->setMovie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MovieGenre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(MovieGenre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    public function removeGenre(MovieGenre $genre): self
    {
        if ($this->genres->contains($genre)) {
            $this->genres->removeElement($genre);
        }

        return $this;
    }

    public function getImdbLink(): ?string
    {
        return $this->imdbLink;
    }

    public function setImdbLink(?string $imdbLink): self
    {
        $this->imdbLink = $imdbLink;

        return $this;
    }
}
