<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // #[ORM\OneToOne(inversedBy: 'evaluation', cascade: ['persist', 'remove'])]
    // #[ORM\JoinColumn(nullable: false)]
    // private ?Stage $stage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $assuiduite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ponctualite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $disponibilite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $interet = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $respect = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $esprit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $aptitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $organisation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $application = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $recherche = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    private ?Stage $stage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getStage(): ?Stage
    // {
    //     return $this->stage;
    // }

    // public function setStage(Stage $stage): static
    // {
    //     $this->stage = $stage;

    //     return $this;
    // }

    public function getAssuiduite(): ?string
    {
        return $this->assuiduite;
    }

    public function setAssuiduite(?string $assuiduite): static
    {
        $this->assuiduite = $assuiduite;

        return $this;
    }

    public function getPonctualite(): ?string
    {
        return $this->ponctualite;
    }

    public function setPonctualite(?string $ponctualite): static
    {
        $this->ponctualite = $ponctualite;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(?string $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getInteret(): ?string
    {
        return $this->interet;
    }

    public function setInteret(?string $interet): static
    {
        $this->interet = $interet;

        return $this;
    }

    public function getRespect(): ?string
    {
        return $this->respect;
    }

    public function setRespect(?string $respect): static
    {
        $this->respect = $respect;

        return $this;
    }

    public function getEsprit(): ?string
    {
        return $this->esprit;
    }

    public function setEsprit(?string $esprit): static
    {
        $this->esprit = $esprit;

        return $this;
    }

    public function getAptitude(): ?string
    {
        return $this->aptitude;
    }

    public function setAptitude(?string $aptitude): static
    {
        $this->aptitude = $aptitude;

        return $this;
    }

    public function getOrganisation(): ?string
    {
        return $this->organisation;
    }

    public function setOrganisation(?string $organisation): static
    {
        $this->organisation = $organisation;

        return $this;
    }

    public function getApplication(): ?string
    {
        return $this->application;
    }

    public function setApplication(?string $application): static
    {
        $this->application = $application;

        return $this;
    }

    public function getRecherche(): ?string
    {
        return $this->recherche;
    }

    public function setRecherche(?string $recherche): static
    {
        $this->recherche = $recherche;

        return $this;
    }
    public function calculerNoteSur20(): float
   {
       $correspondance = [
           'excellent' => 19,
           'tres_bien' => 17,
           'bien' => 15,
           'assez_bien' => 13,
           'passable' => 11,
           'insuffisant' => 7,
       ];

       $somme = 0;
       $nombreDeChamps = 10; // nombre total de critères

       $somme += $correspondance[$this->assuiduite] ?? 0;
       $somme += $correspondance[$this->ponctualite] ?? 0;
       $somme += $correspondance[$this->disponibilite] ?? 0;
       $somme += $correspondance[$this->interet] ?? 0;
       $somme += $correspondance[$this->respect] ?? 0;
       $somme += $correspondance[$this->esprit] ?? 0;
       $somme += $correspondance[$this->aptitude] ?? 0;
       $somme += $correspondance[$this->organisation] ?? 0;
       $somme += $correspondance[$this->application] ?? 0;
       $somme += $correspondance[$this->recherche] ?? 0;

       // Calcul de la note sur 20
       $noteSur20 = $somme / $nombreDeChamps;

       return $noteSur20;
   }
    
    // public function __toString()
    // {
    //     return (string) $this->calculerNoteSur20();
    // }

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

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): static
    {
        $this->stage = $stage;

        return $this;
    }
}
