<?php

namespace App\Entity;

use App\Repository\CourrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: CourrierRepository::class)]
class Courrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
     private ?string $numero_odre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[NotBlank(message:"Veillez renseigner la date de reception")]
    private ?\DateTimeInterface $date_reception = null;

    #[ORM\Column(length: 255)]
    #[NotBlank(message:"Veillez renseigner le expediteur du courrier")]
    private ?string $expediteur = null;

    #[ORM\Column(length: 255)]
    #[NotBlank(message:"Veillez renseigner le destinataire du courrier")]
    private ?string $destinataire = null;

    #[ORM\Column(length: 255)]
    #[NotBlank(message:"Veillez entrer l'objet du courrier")]
    private ?string $objet = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[NotBlank(message:"Veillez entrer une breve description sur le courrier recu")]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'courriers')]
    // #[Length(min:5, minMessage:"Veuiller selectioner un type ")]
    #[NotBlank(message:"Veillez renseigner le type de courrier recu")]
    private ?TypeCourrier $type_courrier = null;

    #[ORM\OneToMany(targetEntity: Historique::class, mappedBy: 'courrier_id')]
    private Collection $historiques;

    ##[ORM\OneToMany(targetEntity: PieceJointe::class, mappedBy: 'courrier', orphanRemoval: true)]
    #private Collection $piece_jointe;

    #[ORM\Column(length: 255)]
    #[NotBlank(message:"Veillez telecharger le fichier ")]
    private ?string $pieceJointe = null;

    // public function __construct()
    // {
    //     $this->historiques = new ArrayCollection();
    //     $this->piece_jointe = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroOdre(): ?string
    {
        return $this->numero_odre;
    }

    public function setNumeroOdre(string $numero_odre): static
    {
        $this->numero_odre = $numero_odre;

        return $this;
    }

    public function getDateReception(): ?\DateTimeInterface
    {
        return $this->date_reception;
    }

    public function setDateReception(\DateTimeInterface $date_reception): static
    {
        $this->date_reception = $date_reception;

        return $this;
    }

    public function getExpediteur(): ?string
    {
        return $this->expediteur;
    }

    public function setExpediteur(string $expediteur): static
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    public function getDestinataire(): ?string
    {
        return $this->destinataire;
    }

    public function setDestinataire(string $destinataire): static
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): static
    {
        $this->objet = $objet;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTypeCourrier(): ?TypeCourrier
    {
        return $this->type_courrier;
    }

    public function setTypeCourrier(?TypeCourrier $type_courrier): static
    {
        $this->type_courrier = $type_courrier;

        return $this;
    }

    /**
     * @return Collection<int, Historique>
     */
    public function getHistoriques(): Collection
    {
        return $this->historiques;
    }

    public function addHistorique(Historique $historique): static
    {
        if (!$this->historiques->contains($historique)) {
            $this->historiques->add($historique);
            $historique->setCourrierId($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): static
    {
        if ($this->historiques->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getCourrierId() === $this) {
                $historique->setCourrierId(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, PieceJointe>
    //  */
    // public function getPieceJointe(): Collection
    // {
    //     return $this->piece_jointe;
    // }

    // public function addPieceJointe(PieceJointe $pieceJointe): static
    // {
    //     if (!$this->piece_jointe->contains($pieceJointe)) {
    //         $this->piece_jointe->add($pieceJointe);
    //         $pieceJointe->setCourrier($this);
    //     }

    //     return $this;
    // }

    // public function removePieceJointe(PieceJointe $pieceJointe): static
    // {
    //     if ($this->piece_jointe->removeElement($pieceJointe)) {
    //         // set the owning side to null (unless already changed)
    //         if ($pieceJointe->getCourrier() === $this) {
    //             $pieceJointe->setCourrier(null);
    //         }
    //     }

    //     return $this;
    // }

    public function setPieceJointe(string $pieceJointe): static
    {
        $this->pieceJointe = $pieceJointe;

        return $this;
    }
    public function getPieceJointe()
    {
        return $this->pieceJointe;
    }
    
   
}
