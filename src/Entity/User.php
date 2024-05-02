<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @Orm\Entity(repositoryClass="App\Repository\UserRepository")
 */
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=300, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=300, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=300, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=300, nullable=false)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="verification_code", type="string", length=300, nullable=false)
     */
    private $verificationCode="1234";

    /**
     * @var bool|null
     *
     * @ORM\Column(name="isActive", type="boolean", nullable=true, options={"default"="1"})
     */
    private $isactive = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date ;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getVerificationCode(): ?string
    {
        return $this->verificationCode;
    }

    public function setVerificationCode(string $verificationCode): static
    {
        $this->verificationCode = $verificationCode;

        return $this;
    }

    public function isIsactive(): ?bool
    {
        return $this->isactive;
    }

    public function setIsactive(?bool $isactive): static
    {
        $this->isactive = $isactive;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function getSalt(): ?string
    {
        // You can leave this method blank or return a salt
        return null;
    }

    public function getUsername(): ?string
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function getIdentifier():string
    {
        return $this->email;
    }
    public function getUserIdentifier():string
    {
        return $this->email;
    }
     /**
     * @ORM\OneToOne(targetEntity="App\Entity\InformationPersonnele", mappedBy="user")
     */
    private $informationPersonnelle;

    public function getInformationPersonnelle(): ?InformationPersonnele
    {
        return $this->informationPersonnelle;
    }
    public function __toString(): string
    {
        // Retourne une représentation string de l'objet, par exemple le nom de l'aéroport
        return $this->id;
    }

}
