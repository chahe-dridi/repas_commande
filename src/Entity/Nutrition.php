<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nutrition
 *
 * @ORM\Table(name="nutrition")
 * @ORM\Entity
 */
class Nutrition
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
     * @var int|null
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="id_ingredient", type="integer", nullable=false)
     */
    private $idIngredient;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_recette", type="integer", nullable=true)
     */
    private $idRecette;

    /**
     * @var string
     *
     * @ORM\Column(name="calories", type="string", length=300, nullable=false)
     */
    private $calories;

    /**
     * @var string
     *
     * @ORM\Column(name="carbs", type="string", length=300, nullable=false)
     */
    private $carbs;

    /**
     * @var string
     *
     * @ORM\Column(name="fat", type="string", length=300, nullable=false)
     */
    private $fat;

    /**
     * @var string
     *
     * @ORM\Column(name="fiber", type="string", length=300, nullable=false)
     */
    private $fiber;

    /**
     * @var string
     *
     * @ORM\Column(name="protein", type="string", length=300, nullable=false)
     */
    private $protein;

    /**
     * @var string
     *
     * @ORM\Column(name="vitamines", type="string", length=300, nullable=false)
     */
    private $vitamines;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=256, nullable=true)
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getIdIngredient(): ?int
    {
        return $this->idIngredient;
    }

    public function setIdIngredient(int $idIngredient): static
    {
        $this->idIngredient = $idIngredient;

        return $this;
    }

    public function getIdRecette(): ?int
    {
        return $this->idRecette;
    }

    public function setIdRecette(?int $idRecette): static
    {
        $this->idRecette = $idRecette;

        return $this;
    }

    public function getCalories(): ?string
    {
        return $this->calories;
    }

    public function setCalories(string $calories): static
    {
        $this->calories = $calories;

        return $this;
    }

    public function getCarbs(): ?string
    {
        return $this->carbs;
    }

    public function setCarbs(string $carbs): static
    {
        $this->carbs = $carbs;

        return $this;
    }

    public function getFat(): ?string
    {
        return $this->fat;
    }

    public function setFat(string $fat): static
    {
        $this->fat = $fat;

        return $this;
    }

    public function getFiber(): ?string
    {
        return $this->fiber;
    }

    public function setFiber(string $fiber): static
    {
        $this->fiber = $fiber;

        return $this;
    }

    public function getProtein(): ?string
    {
        return $this->protein;
    }

    public function setProtein(string $protein): static
    {
        $this->protein = $protein;

        return $this;
    }

    public function getVitamines(): ?string
    {
        return $this->vitamines;
    }

    public function setVitamines(string $vitamines): static
    {
        $this->vitamines = $vitamines;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }


}
