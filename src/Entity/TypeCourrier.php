<?php

namespace App\Entity;

use App\Repository\TypeCourrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeCourrierRepository::class)]
class TypeCourrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToMany(targetEntity: Courrier::class, mappedBy: 'type_courrier')]
    private Collection $courriers;

    public function __construct()
    {
        $this->courriers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Courrier>
     */
    public function getCourriers(): Collection
    {
        return $this->courriers;
    }

    public function addCourrier(Courrier $courrier): static
    {
        if (!$this->courriers->contains($courrier)) {
            $this->courriers->add($courrier);
            $courrier->setTypeCourrier($this);
        }

        return $this;
    }

    public function removeCourrier(Courrier $courrier): static
    {
        if ($this->courriers->removeElement($courrier)) {
            // set the owning side to null (unless already changed)
            if ($courrier->getTypeCourrier() === $this) {
                $courrier->setTypeCourrier(null);
            }
        }

        return $this;
    }
}
