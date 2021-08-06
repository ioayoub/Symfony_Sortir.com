<?php

namespace App\Entity;

use App\Repository\TripsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Length(min=5)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $dateStart;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=30, max=240)
     */
    private $duration;

    /**
     * @ORM\Column(type="date")
     */
    private $limitRegisterDate;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1, max=20)
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

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="isSubscribed_id")
     * @ORM\JoinTable(name="trips_user")
     */
    private $isSubscribed;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="trips")
     */
    private $tripsPlace;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isRegistered;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbRegistered = 0;

    public function __construct()
    {
        $this->isSubscribed = new ArrayCollection();
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

    public function setOrganizer(?Campus $organizer): self
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

    /**
     * @return Collection|User[]
     */
    public function getIsSubscribed(): Collection
    {
        return $this->isSubscribed;
    }

    public function addIsSubscribed(User $isSubscribed): self
    {
        if (!$this->isSubscribed->contains($isSubscribed)) {
            $this->isSubscribed[] = $isSubscribed;
        }

        return $this;
    }

    public function removeIsSubscribed(User $isSubscribed): self
    {
        $this->isSubscribed->removeElement($isSubscribed);

        return $this;
    }


    /**
     * Set the value of isSubscribed
     */
    public function setIsSubscribed($isSubscribed): self
    {
        $this->isSubscribed = $isSubscribed;

        return $this;
    }

    public function getTripsPlace(): ?Place
    {
        return $this->tripsPlace;
    }

    public function setTripsPlace(?Place $tripsPlace): self
    {
        $this->tripsPlace = $tripsPlace;

        return $this;
    }

    public function getIsRegistered(): ?bool
    {
        return $this->isRegistered;
    }

    public function setIsRegistered(?bool $isRegistered): self
    {
        $this->isRegistered = $isRegistered;

        return $this;
    }

    public function getNbRegistered(): ?int
    {
        return $this->nbRegistered;
    }

    public function setNbRegistered(int $nbRegistered): self
    {
        $this->nbRegistered = $nbRegistered;

        return $this;
    }
}
