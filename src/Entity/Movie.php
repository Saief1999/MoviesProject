<?php

namespace App\Entity;

use App\Repository\MovieRepository;
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
     * @ORM\Column(type="string", length=75)
     */
    private $MovieName;

    /**
     * @ORM\Column(type="date")
     */
    private $ReleaseDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Rating;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $RunTime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ProductionCompanies;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Plot;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovieName(): ?string
    {
        return $this->MovieName;
    }

    public function setMovieName(string $MovieName): self
    {
        $this->MovieName = $MovieName;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->ReleaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $ReleaseDate): self
    {
        $this->ReleaseDate = $ReleaseDate;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->Rating;
    }

    public function setRating(?float $Rating): self
    {
        $this->Rating = $Rating;

        return $this;
    }

    public function getRunTime(): ?string
    {
        return $this->RunTime;
    }

    public function setRunTime(?string $RunTime): self
    {
        $this->RunTime = $RunTime;

        return $this;
    }

    public function getProductionCompanies(): ?string
    {
        return $this->ProductionCompanies;
    }

    public function setProductionCompanies(?string $ProductionCompanies): self
    {
        $this->ProductionCompanies = $ProductionCompanies;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->Plot;
    }

    public function setPlot(string $Plot): self
    {
        $this->Plot = $Plot;

        return $this;
    }
}
