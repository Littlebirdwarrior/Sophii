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

    public function __construct()
    {
        $this->parentsEleve = new ArrayCollection();
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
}
