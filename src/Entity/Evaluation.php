<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'evaluation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stage $stage = null;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(Stage $stage): static
    {
        $this->stage = $stage;

        return $this;
    }

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
}
