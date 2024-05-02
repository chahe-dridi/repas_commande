<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ajoutingredientrequest
 *
 * @ORM\Table(name="ajoutingredientrequest")
 * @ORM\Entity
 */
class Ajoutingredientrequest
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
     * @ORM\Column(name="id_chef", type="integer", nullable=false)
     */
    private $idChef;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_ingredient", type="string", length=256, nullable=false)
     */
    private $nomIngredient;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_recette", type="string", length=256, nullable=true)
     */
    private $nomRecette;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=256, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="etat", type="string", length=256, nullable=true)
     */
    private $etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdChef(): ?int
    {
        return $this->idChef;
    }

    public function setIdChef(int $idChef): static
    {
        $this->idChef = $idChef;

        return $this;
    }

    public function getNomIngredient(): ?string
    {
        return $this->nomIngredient;
    }

    public function setNomIngredient(string $nomIngredient): static
    {
        $this->nomIngredient = $nomIngredient;

        return $this;
    }

    public function getNomRecette(): ?string
    {
        return $this->nomRecette;
    }

    public function setNomRecette(?string $nomRecette): static
    {
        $this->nomRecette = $nomRecette;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }


}
