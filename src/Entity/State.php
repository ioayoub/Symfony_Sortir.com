<?php

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StateRepository::class)
 */
class State
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
     * @ORM\OneToMany(targetEntity=Trips::class, mappedBy="state", orphanRemoval=true)
     */
    private $state;

    public function __construct()
    {
        $this->state = new ArrayCollection();
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
     * @return Collection|Trips[]
     */
    public function getState(): Collection
    {
        return $this->state;
    }

    public function addState(Trips $state): self
    {
        if (!$this->state->contains($state)) {
            $this->state[] = $state;
            $state->setState($this);
        }

        return $this;
    }

    public function removeState(Trips $state): self
    {
        if ($this->state->removeElement($state)) {
            // set the owning side to null (unless already changed)
            if ($state->getState() === $this) {
                $state->setState(null);
            }
        }

        return $this;
    }
}
