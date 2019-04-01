<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     */
    private $reponseEnfant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entrainement", inversedBy="question", cascade={"persist", "remove"})
     */
    private $entrainement;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ReponsePropose", inversedBy="questions", cascade={"persist", "remove"})
     */
    private $reponsepropose;

    public function __construct()
    {
        $this->reponsepropose = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getReponseEnfant(): ?int
    {
        return $this->reponseEnfant;
    }

    public function setReponseEnfant(int $reponseEnfant): self
    {
        $this->reponseEnfant = $reponseEnfant;

        return $this;
    }

    public function getEntrainement(): ?Entrainement
    {
        return $this->entrainement;
    }

    public function setEntrainement(?Entrainement $entrainement): self
    {
        $this->entrainement = $entrainement;

        return $this;
    }

    /**
     * @return Collection|ReponsePropose[]
     */
    public function getReponsepropose(): Collection
    {
        return $this->reponsepropose;
    }

    public function addReponsepropose(ReponsePropose $reponsepropose): self
    {
        if (!$this->reponsepropose->contains($reponsepropose)) {
            $this->reponsepropose[] = $reponsepropose;
        }

        return $this;
    }

    public function removeReponsepropose(ReponsePropose $reponsepropose): self
    {
        if ($this->reponsepropose->contains($reponsepropose)) {
            $this->reponsepropose->removeElement($reponsepropose);
        }

        return $this;
    }
}
