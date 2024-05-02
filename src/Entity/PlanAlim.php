<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanAlim
 *
 * @ORM\Table(name="plan_alim", indexes={@ORM\Index(name="id_regime", columns={"id_regime"})})
 * @ORM\Entity
 */
class PlanAlim
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
     * @ORM\Column(name="id_nut", type="integer", nullable=false)
     */
    private $idNut;

    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var \Regime
     *
     * @ORM\ManyToOne(targetEntity="Regime")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_regime", referencedColumnName="id")
     * })
     */
    private $idRegime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdNut(): ?int
    {
        return $this->idNut;
    }

    public function setIdNut(int $idNut): static
    {
        $this->idNut = $idNut;

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

    public function getIdRegime(): ?Regime
    {
        return $this->idRegime;
    }

    public function setIdRegime(?Regime $idRegime): static
    {
        $this->idRegime = $idRegime;

        return $this;
    }


}
