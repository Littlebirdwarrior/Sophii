<?php

namespace App\Entity;

use App\Repository\FamilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamilleRepository::class)]
class Famille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'famille', targetEntity: ParentEleve::class)]
    private Collection $parentsEleve;

    #[ORM\OneToMany(mappedBy: 'famille', targetEntity: Eleve::class)]
    private Collection $eleves;

    public function __construct()
    {
        $this->parentsEleve = new ArrayCollection();
        $this->eleves = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ParentEleve>
     */
    public function getParentsEleve(): Collection
    {
        return $this->parentsEleve;
    }

    public function addParentsEleve(ParentEleve $parentsEleve): self
    {
        if (!$this->parentsEleve->contains($parentsEleve)) {
            $this->parentsEleve->add($parentsEleve);
            $parentsEleve->setFamille($this);
        }

        return $this;
    }

    public function removeParentsEleve(ParentEleve $parentsEleve): self
    {
        if ($this->parentsEleve->removeElement($parentsEleve)) {
            // set the owning side to null (unless already changed)
            if ($parentsEleve->getFamille() === $this) {
                $parentsEleve->setFamille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Eleve>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(Eleve $elefe): self
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves->add($elefe);
            $elefe->setFamille($this);
        }

        return $this;
    }

    public function removeElefe(Eleve $elefe): self
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getFamille() === $this) {
                $elefe->setFamille(null);
            }
        }

        return $this;
    }


}