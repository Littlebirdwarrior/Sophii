<?php

namespace App\Entity;

use App\Repository\ConsigneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsigneRepository::class)]
class Consigne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?bool $validation = null;

    #[ORM\ManyToMany(targetEntity: GroupeConsignes::class, inversedBy: 'consignes')]
    private Collection $groupesconsignes;

    public function __construct()
    {
        $this->groupesconsignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function isValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(bool $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * @return Collection<int, GroupeConsignes>
     */
    public function getGroupesconsignes(): Collection
    {
        return $this->groupesconsignes;
    }

    public function addGroupesconsigne(GroupeConsignes $groupesconsigne): self
    {
        if (!$this->groupesconsignes->contains($groupesconsigne)) {
            $this->groupesconsignes->add($groupesconsigne);
        }

        return $this;
    }

    public function removeGroupesconsigne(GroupeConsignes $groupesconsigne): self
    {
        $this->groupesconsignes->removeElement($groupesconsigne);

        return $this;
    }

    public function __toString()
    {
        //."(Groupe : ". $this->groupesconsignes.")"
        return "Libelle " . $this->libelle ;
    }
}
