<?php

namespace App\Entity;

use App\Repository\PlanningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlanningRepository::class)
 */
class Planning
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $startingDate;

    /**
     * @ORM\OneToMany(targetEntity=MoviePlanning::class, mappedBy="planning", orphanRemoval=true)
     */
    private $moviePlannings;

    /**
     * @ORM\ManyToOne(targetEntity=Cinema::class, inversedBy="plannings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cinema;

    public function __construct()
    {
        $this->moviePlannings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingDate(): ?\DateTimeInterface
    {
        return $this->startingDate;
    }

    public function setStartingDate(\DateTimeInterface $startingDate): self
    {
        $this->startingDate = $startingDate;

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
            $moviePlanning->setPlanning($this);
        }

        return $this;
    }

    public function removeMoviePlanning(MoviePlanning $moviePlanning): self
    {
        if ($this->moviePlannings->contains($moviePlanning)) {
            $this->moviePlannings->removeElement($moviePlanning);
            // set the owning side to null (unless already changed)
            if ($moviePlanning->getPlanning() === $this) {
                $moviePlanning->setPlanning(null);
            }
        }

        return $this;
    }

    public function getCinema(): ?Cinema
    {
        return $this->cinema;
    }

    public function setCinema(?Cinema $cinema): self
    {
        $this->cinema = $cinema;

        return $this;
    }
}
