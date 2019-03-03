<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 */
class Region
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgMagicien;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PNJ", mappedBy="region")
     */
    private $pnj;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\TableDeMultiplication", inversedBy="region", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tabledemultiplication;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImgMagicien(): ?string
    {
        return $this->imgMagicien;
    }

    public function setImgMagicien(string $imgMagicien): self
    {
        $this->imgMagicien = $imgMagicien;

        return $this;
    }

    public function getPnj(): ?PNJ
    {
        return $this->pnj;
    }

    public function setPnj(PNJ $pnj): self
    {
        $this->pnj = $pnj;

        // set the owning side of the relation if necessary
        if ($this !== $pnj->getRegion()) {
            $pnj->setRegion($this);
        }

        return $this;
    }

    public function getTabledemultiplication(): ?TableDeMultiplication
    {
        return $this->tabledemultiplication;
    }

    public function setTabledemultiplication(TableDeMultiplication $tabledemultiplication): self
    {
        $this->tabledemultiplication = $tabledemultiplication;

        return $this;
    }
}
