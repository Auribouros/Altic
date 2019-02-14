<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estEnseignant;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Niveau", mappedBy="utilisateur")
     */
    private $niveaux;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PersonnageJouable", inversedBy="utilisateurs")
     */
    private $personnagejouable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entrainement", mappedBy="utilisateur")
     */
    private $entrainement;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Utilisateur", inversedBy="utilisateurs")
     */
    private $utilisateurLie;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Utilisateur", mappedBy="utilisateurLie")
     */
    private $utilisateurs;

    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
        $this->personnagejouable = new ArrayCollection();
        $this->entrainement = new ArrayCollection();
        $this->utilisateurLie = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEstEnseignant(): ?bool
    {
        return $this->estEnseignant;
    }

    public function setEstEnseignant(bool $estEnseignant): self
    {
        $this->estEnseignant = $estEnseignant;

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->addUtilisateur($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->contains($niveau)) {
            $this->niveaux->removeElement($niveau);
            $niveau->removeUtilisateur($this);
        }

        return $this;
    }

    /**
     * @return Collection|PersonnageJouable[]
     */
    public function getPersonnagejouable(): Collection
    {
        return $this->personnagejouable;
    }

    public function addPersonnagejouable(PersonnageJouable $personnagejouable): self
    {
        if (!$this->personnagejouable->contains($personnagejouable)) {
            $this->personnagejouable[] = $personnagejouable;
        }

        return $this;
    }

    public function removePersonnagejouable(PersonnageJouable $personnagejouable): self
    {
        if ($this->personnagejouable->contains($personnagejouable)) {
            $this->personnagejouable->removeElement($personnagejouable);
        }

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
            $entrainement->setUtilisateur($this);
        }

        return $this;
    }

    public function removeEntrainement(Entrainement $entrainement): self
    {
        if ($this->entrainement->contains($entrainement)) {
            $this->entrainement->removeElement($entrainement);
            // set the owning side to null (unless already changed)
            if ($entrainement->getUtilisateur() === $this) {
                $entrainement->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getUtilisateurLie(): Collection
    {
        return $this->utilisateurLie;
    }

    public function addUtilisateurLie(self $utilisateurLie): self
    {
        if (!$this->utilisateurLie->contains($utilisateurLie)) {
            $this->utilisateurLie[] = $utilisateurLie;
        }

        return $this;
    }

    public function removeUtilisateurLie(self $utilisateurLie): self
    {
        if ($this->utilisateurLie->contains($utilisateurLie)) {
            $this->utilisateurLie->removeElement($utilisateurLie);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(self $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->addUtilisateurLie($this);
        }

        return $this;
    }

    public function removeUtilisateur(self $utilisateur): self
    {
        if ($this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->removeElement($utilisateur);
            $utilisateur->removeUtilisateurLie($this);
        }

        return $this;
    }
}
