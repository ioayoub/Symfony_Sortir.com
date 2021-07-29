<?php

namespace App\Entity;

use App\Repository\TripsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TripsRepository::class)
 */
class Trips
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
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="date")
     */
    private $limitRegisterDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxRegistrations;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tripInformations;


    /**
     * @ORM\ManyToOne(targetEntity=State::class, inversedBy="state")
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="trips")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organizer;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trips")
     */
    private $isOrganizer;

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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getLimitRegisterDate(): ?\DateTimeInterface
    {
        return $this->limitRegisterDate;
    }

    public function setLimitRegisterDate(\DateTimeInterface $limitRegisterDate): self
    {
        $this->limitRegisterDate = $limitRegisterDate;

        return $this;
    }

    public function getMaxRegistrations(): ?int
    {
        return $this->maxRegistrations;
    }

    public function setMaxRegistrations(int $maxRegistrations): self
    {
        $this->maxRegistrations = $maxRegistrations;

        return $this;
    }

    public function getTripInformations(): ?string
    {
        return $this->tripInformations;
    }

    public function setTripInformations(?string $tripInformations): self
    {
        $this->tripInformations = $tripInformations;

        return $this;
    }


    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getOrganizer(): ?Campus
    {
        return $this->organizer;
    }

    public function setOrganizer(Campus $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getIsOrganizer(): ?User
    {
        return $this->isOrganizer;
    }

    public function setIsOrganizer(?User $isOrganizer): self
    {
        $this->isOrganizer = $isOrganizer;

        return $this;
    }
}
