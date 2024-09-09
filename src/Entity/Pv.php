<?php

namespace App\Entity;

use App\Repository\PvRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PvRepository::class)]
class Pv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pvs')]
    private ?controle $courrier_demande = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_pv = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path_pv = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourrierDemande(): ?controle
    {
        return $this->courrier_demande;
    }

    public function setCourrierDemande(?controle $courrier_demande): static
    {
        $this->courrier_demande = $courrier_demande;

        return $this;
    }

    public function getDatePv(): ?\DateTimeInterface
    {
        return $this->date_pv;
    }

    public function setDatePv(\DateTimeInterface $date_pv): static
    {
        $this->date_pv = $date_pv;

        return $this;
    }

    public function getPathPv(): ?string
    {
        return $this->path_pv;
    }

    public function setPathPv(?string $path_pv): static
    {
        $this->path_pv = $path_pv;

        return $this;
    }
}
