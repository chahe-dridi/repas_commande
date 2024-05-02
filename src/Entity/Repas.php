<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Repas
 *
 * @ORM\Table(name="repas", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_recette", columns={"id_recette"})})
 * @ORM\Entity
 */
class Repas
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
     * @var int
     *
     * @ORM\Column(name="id_recette", type="integer", nullable=false)
     */
    private $idRecette;

    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=300, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=300, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="string", length=300, nullable=false)
     */
    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRecette(): ?int
    {
        return $this->idRecette;
    }

    public function setIdRecette(int $idRecette): static
    {
        $this->idRecette = $idRecette;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(string $tags): static
    {
        $this->tags = $tags;

        return $this;
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


}
