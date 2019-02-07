<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TableDeMultiplicationRepository")
 */
class TableDeMultiplication
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Region", mappedBy="tabledemultiplication", cascade={"persist", "remove"})
     */
    private $region;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Niveau", inversedBy="tableDeMultiplications")
     */
    private $niveau;

    public function __construct()
    {
        $this->niveau = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(Region $region): self
    {
        $this->region = $region;

        // set the owning side of the relation if necessary
        if ($this !== $region->getTabledemultiplication()) {
            $region->setTabledemultiplication($this);
        }

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveau(): Collection
    {
        return $this->niveau;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveau->contains($niveau)) {
            $this->niveau[] = $niveau;
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveau->contains($niveau)) {
            $this->niveau->removeElement($niveau);
        }

        return $this;
    }
}
