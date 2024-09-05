<?php

namespace App\Entity;

use App\Repository\ControleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ControleRepository::class)]
class Controle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'controle', cascade: ['persist', 'remove'])]
    private ?Courrier $courrier_demande = null;

    #[ORM\Column]
    private ?bool $statut_demande = null;

    #[ORM\Column(nullable: true)]
    private ?bool $statut_controle = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_controle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourrierDemande(): ?Courrier
    {
        return $this->courrier_demande;
    }

    public function setCourrierDemande(?Courrier $courrier_demande): static
    {
        $this->courrier_demande = $courrier_demande;

        return $this;
    }

    public function isStatutDemande(): ?bool
    {
        return $this->statut_demande;
    }

    public function setStatutDemande(bool $statut_demande): static
    {
        $this->statut_demande = $statut_demande;

        return $this;
    }

    public function isStatutControle(): ?bool
    {
        return $this->statut_controle;
    }

    public function setStatutControle(?bool $statut_controle): static
    {
        $this->statut_controle = $statut_controle;

        return $this;
    }

    public function getDateControle(): ?\DateTimeInterface
    {
        return $this->date_controle;
    }

    public function setDateControle(?\DateTimeInterface $date_controle): static
    {
        $this->date_controle = $date_controle;

        return $this;
    }
}
