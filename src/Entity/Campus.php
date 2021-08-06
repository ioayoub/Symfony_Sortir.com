<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CampusRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CampusRepository::class)
 * @UniqueEntity("name", message="Ce campus est déjà ")
 */
class Campus
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="name",type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="campus")
     */
    private $user_campus;

    /**
     * @ORM\OneToMany(targetEntity=Trips::class, mappedBy="organizer")
     */
    private $trips;



    public function __construct()
    {
        $this->user_campus = new ArrayCollection();
        $this->trips = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getUserCampus(): Collection
    {
        return $this->user_campus;
    }

    public function addUserCampus(User $userCampus): self
    {
        if (!$this->user_campus->contains($userCampus)) {
            $this->user_campus[] = $userCampus;
            $userCampus->setCampus($this);
        }

        return $this;
    }

    public function removeUserCampus(User $userCampus): self
    {
        if ($this->user_campus->removeElement($userCampus)) {
            // set the owning side to null (unless already changed)
            if ($userCampus->getCampus() === $this) {
                $userCampus->setCampus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Trips[]
     */
    public function getTrips(): Collection
    {
        return $this->trips;
    }

    public function addTrip(Trips $trip): self
    {
        if (!$this->trips->contains($trip)) {
            $this->trips[] = $trip;
            $trip->setOrganizer($this);
        }

        return $this;
    }

    public function removeTrip(Trips $trip): self
    {
        if ($this->trips->removeElement($trip)) {
            // set the owning side to null (unless already changed)
            if ($trip->getOrganizer() === $this) {
                $trip->setOrganizer(null);
            }
        }

        return $this;
    }
}
