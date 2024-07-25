<?php

namespace App\Entity;

use App\Repository\PieceJointeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PieceJointeRepository::class)]
class PieceJointe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lien = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'piece_jointe')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Courrier $courrier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): static
    {
        $this->lien = $lien;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCourrier(): ?Courrier
    {
        return $this->courrier;
    }

    public function setCourrier(?Courrier $courrier): static
    {
        $this->courrier = $courrier;

        return $this;
    }
}
