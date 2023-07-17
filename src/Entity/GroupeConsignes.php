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

    #[ORM\ManyToMany(targetEntity: Consigne::class, mappedBy: 'groupesconsignes')]
    private Collection $consignes;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
        $this->consignes = new ArrayCollection();
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

    /**
     * @return Collection<int, Consigne>
     */
    public function getConsignes(): Collection
    {
        return $this->consignes;
    }

    public function addConsigne(Consigne $consigne): self
    {
        if (!$this->consignes->contains($consigne)) {
            $this->consignes->add($consigne);
            $consigne->addGroupesconsigne($this);
        }

        return $this;
    }

    public function removeConsigne(Consigne $consigne): self
    {
        if ($this->consignes->removeElement($consigne)) {
            $consigne->removeGroupesconsigne($this);
        }

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function __toString()
    {
        return "Titre " . $this->titre ;
    }

}
