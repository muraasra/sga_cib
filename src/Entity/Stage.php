<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StageRepository::class)]
class Stage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $theme = null;

    #[ORM\ManyToOne(inversedBy: 'stages')]
    private ?Stagiaire $stagiaire = null;

    // #[ORM\OneToOne(mappedBy: 'stage', cascade: ['persist', 'remove'])]
    // private ?Evaluation $evaluation = null;

    #[ORM\ManyToOne(inversedBy: 'stages')]
    private ?TypeStage $type_stage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rapport = null;

    #[ORM\OneToMany(targetEntity: Evaluation::class, mappedBy: 'stage')]
    private Collection $evaluations;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function getStagiaire(): ?stagiaire
    {
        return $this->stagiaire;
    }

    public function setStagiaire(?stagiaire $stagiaire): static
    {
        $this->stagiaire = $stagiaire;

        return $this;
    }
    public function getTypeStage(): ?TypeStage
    {
        return $this->type_stage;
    }

    public function setTypeStage(?TypeStage $type_stage): static
    {
        $this->type_stage = $type_stage;

        return $this;
    }

    public function getRapport(): ?string
    {
        return $this->rapport;
    }

    public function setRapport(?string $rapport): static
    {
        $this->rapport = $rapport;

        return $this;
    }
    // public function getEvaluation(): ?Evaluation
    // {
    //     return $this->evaluation;
    // }

    // public function setEvaluation(Evaluation $evaluation): static
    // {
    //     // set the owning side of the relation if necessary
    //     if ($evaluation->getStage() !== $this) {
    //         $evaluation->setStage($this);
    //     }

    //     $this->evaluation = $evaluation;

    //     return $this;
    // }
    // public function __toString(){
    //     return (string) $this->theme;
    // }

    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): static
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
            $evaluation->setStage($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): static
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getStage() === $this) {
                $evaluation->setStage(null);
            }
        }

        return $this;
    }

  
}
