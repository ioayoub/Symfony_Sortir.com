<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 * @UniqueEntity("username",message="Ce pseudo est déjà utilisée.")
 * @UniqueEntity("email",message="Cet email est déjà utilisé.")
 * 
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

    /**
     * @var File|null
     * @Assert\Image(mimeTypes="image/jpeg", maxSize="6000000")
     * @Vich\UploadableField(mapping="users_image", fileNameProperty="imageName", size="imageSize")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer")
     * @var int|null
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updated_at;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }


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
    /**
     * Get the value of imageName
     */
    public function getimageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * Set the value of imageName
     */
    public function setimageName(?string $imageName): User
    {
        $this->imageName = $imageName;

        return $this;
    }

    /** 
     * Get the value of imageFile
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     */
    public function setImageFile(File $imageFile)
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of imageSize
     */
    public function getimageSize()
    {
        return $this->imageSize;
    }

    /**
     * Set the value of imageSize
     */
    public function setimageSize($imageSize): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }
}
