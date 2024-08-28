<?php

namespace App\Entity;

use App\Repository\StagiaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StagiaireRepository::class)]
class Stagiaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $addresse = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_nais = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $n_cni = null;

    #[ORM\Column(length: 255)]
    private ?string $sexe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $nationalite = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(nullable: true)]
    private ?int $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $filiere = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etablissement = null;

    #[ORM\Column(length: 255)]
    private ?string $classe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path_cv = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path_lettre_motivation = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $is_accept = null;

    #[ORM\ManyToOne(inversedBy: 'stagiaires')]
    private ?User $encadreur = null;

    #[ORM\OneToMany(targetEntity: Stage::class, mappedBy: 'stagiaire')]
    private Collection $stages;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\OneToOne(mappedBy: 'stagiaire', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type_stage = null;
    public function __construct()
    {
        $this->is_accept = 0; // par défaut, le stagiaire n'est pas accepté
        $this->stages = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(string $addresse): static
    {
        $this->addresse = $addresse;

        return $this;
    }

    public function getDateNais(): ?\DateTimeInterface
    {
        return $this->date_nais;
    }

    public function setDateNais(\DateTimeInterface $date_nais): static
    {
        $this->date_nais = $date_nais;

        return $this;
    }

    public function getNCni(): ?string
    {
        return $this->n_cni;
    }

    public function setNCni(?string $n_cni): static
    {
        $this->n_cni = $n_cni;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): static
    {
        $this->nationalite = $nationalite;

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

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getFiliere(): ?string
    {
        return $this->filiere;
    }

    public function setFiliere(string $filiere): static
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getEtablissement(): ?string
    {
        return $this->etablissement;
    }

    public function setEtablissement(?string $etablissement): static
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(string $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getPathCv(): ?string
    {
        return $this->path_cv;
    }

    public function setPathCv(?string $path_cv): static
    {
        $this->path_cv = $path_cv;

        return $this;
    }

    public function getPathLettreMotivation(): ?string
    {
        return $this->path_lettre_motivation;
    }

    public function setPathLettreMotivation(?string $path_lettre_motivation): static
    {
        $this->path_lettre_motivation = $path_lettre_motivation;

        return $this;
    }

    public function getIsAccept(): ?int
    {
        return $this->is_accept;
    }

    public function setIsAccept(int $is_accept): static
    {
        $this->is_accept = $is_accept;

        return $this;
    }

    public function getEncadreur(): ?User
    {
        return $this->encadreur;
    }

    public function setEncadreur(?User $encadreur): static
    {
        $this->encadreur = $encadreur;

        return $this;
    }

    /**
     * @return Collection<int, Stage>
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): static
    {
        if (!$this->stages->contains($stage)) {
            $this->stages->add($stage);
            $stage->setStagiaire($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): static
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getStagiaire() === $this) {
                $stage->setStagiaire(null);
            }
        }

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setStagiaire(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getStagiaire() !== $this) {
            $user->setStagiaire($this);
        }

        $this->user = $user;

        return $this;
    }
    public function __toString(){
        return (string) $this->nom;
    }

    public function getTypeStage(): ?string
    {
        return $this->type_stage;
    }

    public function setTypeStage(?string $type_stage): static
    {
        $this->type_stage = $type_stage;

        return $this;
    }
}
