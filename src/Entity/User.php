<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use PHPUnit\Util\Json;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("username",message="Ce pseudo est déjà utilisée.")
 * @UniqueEntity("email",message="Cet email est déjà utilisé.")
 *  @UniqueEntity("phone",message="Ce numéro de téléphone est déjà utilisé.")
 */
class User implements UserInterface, \Serializable
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(pattern="#^[a-zA-Z]{2,}$#", message="Le pseudo doit contenir au moins 3 caractères")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(pattern="#[a-zA-Z]{2,}#", message="Le prénom doit contenir au moins 2 caractères")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(pattern="#[a-zA-Z]{2,}#", message="Le nom doit contenir au moins 2 caractères")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(pattern="#[0-9]{10}#", message="le numéro de téléphone doit contenir 10 chiffres")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     *
     */
    private $roles = ["ROLE_USER"];

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    private $isActive = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }



    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive = false): self
    {
        $this->isActive = $isActive;

        return $this;
    }


    public function getSalt()
    {
        return null;
    }


    public function getUserIdentifier()
    {
        return $this->getUsername();
    }

    public function eraseCredentials()
    {
    }

    /**
     * Get the value of roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set the value of roles
     */
    public function setRoles($roles): self
    {
        $this->roles = $roles;


        return $this;
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->firstname,
            $this->lastname,
            $this->phone,
            $this->email,
            $this->password,
            $this->roles,
            $this->isActive,
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->firstname,
            $this->lastname,
            $this->phone,
            $this->email,
            $this->password,
            $this->roles,
            $this->isActive,
        ) = unserialize($serialized);
    }
}
