<?php

namespace App\Entity;

use App\Repository\ControleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(targetEntity: Pv::class, mappedBy: 'courrier_demande')]
    private Collection $pvs;

    public function __construct()
    {
        $this->pvs = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Pv>
     */
    public function getPvs(): Collection
    {
        return $this->pvs;
    }

    public function addPv(Pv $pv): static
    {
        if (!$this->pvs->contains($pv)) {
            $this->pvs->add($pv);
            $pv->setCourrierDemande($this);
        }

        return $this;
    }

    public function removePv(Pv $pv): static
    {
        if ($this->pvs->removeElement($pv)) {
            // set the owning side to null (unless already changed)
            if ($pv->getCourrierDemande() === $this) {
                $pv->setCourrierDemande(null);
            }
        }

        return $this;
    }
}
