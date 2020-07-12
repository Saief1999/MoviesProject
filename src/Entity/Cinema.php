<?php

namespace App\Entity;

use App\Repository\CinemaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CinemaRepository::class)
 */
class Cinema
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $adress;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="time")
     */
    private $openingTime;

    /**
     * @ORM\Column(type="time")
     */
    private $closingTime;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagePath;

    /**
     * @ORM\OneToMany(targetEntity=TblComment::class, mappedBy="cinema", orphanRemoval=true)
     */
    private $tblComments;

    /**
     * @ORM\OneToMany(targetEntity=Planning::class, mappedBy="cinema", orphanRemoval=true)
     */
    private $plannings;

    /**
     * @ORM\OneToMany(targetEntity=CinemaRating::class, mappedBy="cinema", orphanRemoval=true)
     */
    private $ratings;
    public function __construct()
    {
        $this->tblComments = new ArrayCollection();
        $this->plannings = new ArrayCollection();
        $this->ratings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getOpeningTime(): ?\DateTimeInterface
    {
        return $this->openingTime;
    }

    public function setOpeningTime(\DateTimeInterface $openingTime): self
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    public function getClosingTime(): ?\DateTimeInterface
    {
        return $this->closingTime;
    }

    public function setClosingTime(\DateTimeInterface $closingTime): self
    {
        $this->closingTime = $closingTime;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): self
    {
        $this->imagePath = $imagePath;

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
            $tblComment->setCinema($this);
        }

        return $this;
    }

    public function removeTblComment(TblComment $tblComment): self
    {
        if ($this->tblComments->contains($tblComment)) {
            $this->tblComments->removeElement($tblComment);
            // set the owning side to null (unless already changed)
            if ($tblComment->getCinema() === $this) {
                $tblComment->setCinema(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Planning[]
     */
    public function getPlannings(): Collection
    {
        return $this->plannings;
    }

    public function addPlanning(Planning $planning): self
    {
        if (!$this->plannings->contains($planning)) {
            $this->plannings[] = $planning;
            $planning->setCinema($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->contains($planning)) {
            $this->plannings->removeElement($planning);
            // set the owning side to null (unless already changed)
            if ($planning->getCinema() === $this) {
                $planning->setCinema(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CinemaRating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(CinemaRating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setMyCinema($this);
        }

        return $this;
    }

    public function removeRating(CinemaRating $rating): self
    {
        if ($this->ratings->contains($rating)) {
            $this->ratings->removeElement($rating);
            // set the owning side to null (unless already changed)
            if ($rating->getMyCinema() === $this) {
                $rating->setMyCinema(null);
            }
        }

        return $this;
    }
}

