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

    /*Quand je supprime une activité, le groupe de consigne correspondant est supprimé*/
    #[ORM\OneToMany(mappedBy: 'groupeconsignes', targetEntity: Activite::class,
        cascade:["persist"], orphanRemoval: true)]
    private Collection $activites;


    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\OneToMany(mappedBy: 'groupeConsignes', targetEntity: Consigne::class)]
    private Collection $consignes;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
        $this->consignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getListConsigne(): array
    {
        $listConsigne = [];
        foreach($this->consignes as $consigne)
        {
            $listConsigne[] = $consigne;
        }
        return $listConsigne;
    }

    public function __toString()
    {
        return "Titre " . $this->titre ;
    }

    /**
     * @return Collection<int, Consigne>
     */
    public function getConsignes(): Collection
    {
        return $this->consignes;
    }

    public function addConsigne(Consigne $consigne): static
    {
        if (!$this->consignes->contains($consigne)) {
            $this->consignes->add($consigne);
            $consigne->setGroupeConsignes($this);
        }

        return $this;
    }

    public function removeConsigne(Consigne $consigne): static
    {
        if ($this->consignes->removeElement($consigne)) {
            // set the owning side to null (unless already changed)
            if ($consigne->getGroupeConsignes() === $this) {
                $consigne->setGroupeConsignes(null);
            }
        }

        return $this;
    }

}
