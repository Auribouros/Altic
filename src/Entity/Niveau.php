<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NiveauRepository")
 */
class Niveau
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
     * @ORM\Column(type="integer")
     */
    private $ecartEntreLesReponses;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreDeReponses;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbReponsesProposeesDeLaMemeTable;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reponsesSimilaires;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tempsDisponible;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $ordreDesQuestions;

    /**
     * @ORM\Column(type="boolean")
     */
    private $questionsATrous;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TableDeMultiplication", mappedBy="niveau")
     */
    private $tableDeMultiplications;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jeu", inversedBy="niveaux")
     * @ORM\JoinColumn(nullable=false)
     */
    private $jeu;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Entrainement", inversedBy="niveaux")
     */
    private $entrainement;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Utilisateur", inversedBy="niveaux")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PersonnageJouable", inversedBy="niveaux")
     */
    private $personnagejouable;

    public function __construct()
    {
        $this->tableDeMultiplications = new ArrayCollection();
        $this->entrainement = new ArrayCollection();
        $this->utilisateur = new ArrayCollection();
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

    public function getEcartEntreLesReponses(): ?int
    {
        return $this->ecartEntreLesReponses;
    }

    public function setEcartEntreLesReponses(int $ecartEntreLesReponses): self
    {
        $this->ecartEntreLesReponses = $ecartEntreLesReponses;

        return $this;
    }

    public function getNombreDeReponses(): ?int
    {
        return $this->nombreDeReponses;
    }

    public function setNombreDeReponses(int $nombreDeReponses): self
    {
        $this->nombreDeReponses = $nombreDeReponses;

        return $this;
    }

    public function getNbReponsesProposeesDeLaMemeTable(): ?int
    {
        return $this->nbReponsesProposeesDeLaMemeTable;
    }

    public function setNbReponsesProposeesDeLaMemeTable(int $nbReponsesProposeesDeLaMemeTable): self
    {
        $this->nbReponsesProposeesDeLaMemeTable = $nbReponsesProposeesDeLaMemeTable;

        return $this;
    }

    public function getReponsesSimilaires(): ?bool
    {
        return $this->reponsesSimilaires;
    }

    public function setReponsesSimilaires(bool $reponsesSimilaires): self
    {
        $this->reponsesSimilaires = $reponsesSimilaires;

        return $this;
    }

    public function getTempsDisponible(): ?int
    {
        return $this->tempsDisponible;
    }

    public function setTempsDisponible(?int $tempsDisponible): self
    {
        $this->tempsDisponible = $tempsDisponible;

        return $this;
    }

    public function getOrdreDesQuestions(): ?string
    {
        return $this->ordreDesQuestions;
    }

    public function setOrdreDesQuestions(string $ordreDesQuestions): self
    {
        $this->ordreDesQuestions = $ordreDesQuestions;

        return $this;
    }

    public function getQuestionsATrous(): ?bool
    {
        return $this->questionsATrous;
    }

    public function setQuestionsATrous(bool $questionsATrous): self
    {
        $this->questionsATrous = $questionsATrous;

        return $this;
    }

    /**
     * @return Collection|TableDeMultiplication[]
     */
    public function getTableDeMultiplications(): Collection
    {
        return $this->tableDeMultiplications;
    }

    public function addTableDeMultiplication(TableDeMultiplication $tableDeMultiplication): self
    {
        if (!$this->tableDeMultiplications->contains($tableDeMultiplication)) {
            $this->tableDeMultiplications[] = $tableDeMultiplication;
            $tableDeMultiplication->addNiveau($this);
        }

        return $this;
    }

    public function removeTableDeMultiplication(TableDeMultiplication $tableDeMultiplication): self
    {
        if ($this->tableDeMultiplications->contains($tableDeMultiplication)) {
            $this->tableDeMultiplications->removeElement($tableDeMultiplication);
            $tableDeMultiplication->removeNiveau($this);
        }

        return $this;
    }

    public function getJeu(): ?Jeu
    {
        return $this->jeu;
    }

    public function setJeu(?Jeu $jeu): self
    {
        $this->jeu = $jeu;

        return $this;
    }

    /**
     * @return Collection|Entrainement[]
     */
    public function getEntrainement(): Collection
    {
        return $this->entrainement;
    }

    public function addEntrainement(Entrainement $entrainement): self
    {
        if (!$this->entrainement->contains($entrainement)) {
            $this->entrainement[] = $entrainement;
        }

        return $this;
    }

    public function removeEntrainement(Entrainement $entrainement): self
    {
        if ($this->entrainement->contains($entrainement)) {
            $this->entrainement->removeElement($entrainement);
        }

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateur(): Collection
    {
        return $this->utilisateur;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateur->contains($utilisateur)) {
            $this->utilisateur[] = $utilisateur;
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateur->contains($utilisateur)) {
            $this->utilisateur->removeElement($utilisateur);
        }

        return $this;
    }

    public function getPersonnagejouable(): ?PersonnageJouable
    {
        return $this->personnagejouable;
    }

    public function setPersonnagejouable(?PersonnageJouable $personnagejouable): self
    {
        $this->personnagejouable = $personnagejouable;

        return $this;
    }
}
