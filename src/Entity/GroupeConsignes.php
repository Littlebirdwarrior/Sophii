<?php

namespace App\Entity;

use App\Repository\GroupeConsignesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupeConsignesRepository::class)]
class GroupeConsignes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'groupeconsignes', targetEntity: Activite::class)]
    private Collection $activites;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Activite>
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites->add($activite);
            $activite->setGroupeconsignes($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getGroupeconsignes() === $this) {
                $activite->setGroupeconsignes(null);
            }
        }

        return $this;
    }
}
