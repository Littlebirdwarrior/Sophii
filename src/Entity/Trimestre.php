<?php

namespace App\Entity;

use App\Repository\TrimestreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrimestreRepository::class)]
class Trimestre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'trimestre', targetEntity: Bulletin::class)]
    private Collection $bulletin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function __construct()
    {
        $this->bulletin = new ArrayCollection();
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @return Collection<int, Bulletin>
     */
    public function getBulletin(): Collection
    {
        return $this->bulletin;
    }

    public function addBulletin(Bulletin $bulletin): self
    {
        if (!$this->bulletin->contains($bulletin)) {
            $this->bulletin->add($bulletin);
            $bulletin->setTrimestre($this);
        }

        return $this;
    }

    public function removeRelation(Bulletin $bulletin): self
    {
        if ($this->bulletin->removeElement($bulletin)) {
            // set the owning side to null (unless already changed)
            if ($bulletin->getTrimestre() === $this) {
                $bulletin->setTrimestre(null);
            }
        }

        return $this;
    }
}
