<?php

namespace App\Entity;

use App\Repository\StagiaireRepository;
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
    public function __construct()
    {
        $this->is_accept = 0; // par défaut, le stagiaire n'est pas accepté
        
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
}
