<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InformationPersonnele
 *
 * @ORM\Table(name="information_personnele", indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 * @Orm\Entity(repositoryClass="App\Repository\InformationPersonneleRepository")
 */
class InformationPersonnele
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
     * @ORM\Column(name="nom", type="string", length=300, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=300, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=300, nullable=false)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="taille", type="string", length=300, nullable=false)
     */
    private $taille;

    /**
     * @var string
     *
     * @ORM\Column(name="poids", type="string", length=300, nullable=false)
     */
    private $poids;

    /**
     * @var string
     *
     * @ORM\Column(name="maladie", type="string", length=300, nullable=false)
     */
    private $maladie;

    /**
     * @var string
     *
     * @ORM\Column(name="num_tel", type="string", length=300, nullable=false)
     */
    private $numTel;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=300, nullable=false)
     */
    private $adresse;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): static
    {
        $this->id = $id;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoids(): ?string
    {
        return $this->poids;
    }

    public function setPoids(string $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getMaladie(): ?string
    {
        return $this->maladie;
    }

    public function setMaladie(?string $maladie): static
    {
        $this->maladie = $maladie ?? '';
    
        return $this;
    }
    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): static
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }


}
