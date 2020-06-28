<?php

namespace App\Entity;

use App\Repository\MoviePlanningRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MoviePlanningRepository::class)
 */
class MoviePlanning
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startingTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endingTime;

    /**
     * @ORM\ManyToOne(targetEntity=Planning::class, inversedBy="moviePlannings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $planning;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="moviePlannings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingTime(): ?\DateTimeInterface
    {
        return $this->startingTime;
    }

    public function setStartingTime(\DateTimeInterface $startingTime): self
    {
        $this->startingTime = $startingTime;

        return $this;
    }

    public function getEndingTime(): ?\DateTimeInterface
    {
        return $this->endingTime;
    }

    public function setEndingTime(\DateTimeInterface $endingTime): self
    {
        $this->endingTime = $endingTime;

        return $this;
    }

    public function getPlanning(): ?Planning
    {
        return $this->planning;
    }

    public function setPlanning(?Planning $planning): self
    {
        $this->planning = $planning;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }
}
