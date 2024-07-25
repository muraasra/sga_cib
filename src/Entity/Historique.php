<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueRepository::class)]
class Historique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $action = null;

    #[ORM\ManyToOne(inversedBy: 'historiques')]
    private ?Courrier $courrier_id = null;

    #[ORM\ManyToOne(inversedBy: 'envois')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $envoyeur = null;

    #[ORM\ManyToOne(inversedBy: 'recus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $receveur = null;

    #[ORM\Column]
    private ?bool $is_read = null;

    public function __construct()
    {
        $this->date = new \DateTime;
        $this->is_read = false;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getCourrierId(): ?Courrier
    {
        return $this->courrier_id;
    }

    public function setCourrierId(?Courrier $courrier_id): static
    {
        $this->courrier_id = $courrier_id;

        return $this;
    }

    public function getEnvoyeur(): ?User
    {
        return $this->envoyeur;
    }

    public function setEnvoyeur(?User $envoyeur): static
    {
        $this->envoyeur = $envoyeur;

        return $this;
    }

    public function getReceveur(): ?User
    {
        return $this->receveur;
    }

    public function setReceveur(?User $receveur): static
    {
        $this->receveur = $receveur;

        return $this;
    }

    public function isIsRead(): ?bool
    {
        return $this->is_read;
    }

    public function setIsRead(bool $is_read): static
    {
        $this->is_read = $is_read;

        return $this;
    }


}
