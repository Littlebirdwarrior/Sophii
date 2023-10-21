<?php

namespace App\Entity;

use App\Repository\ConsigneRepository;
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

    #[ORM\ManyToOne(inversedBy: 'consignes')]
    private ?GroupeConsignes $groupeConsignes = null;


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

    public function getGroupeConsignes(): ?GroupeConsignes
    {
        return $this->groupeConsignes;
    }

    public function setGroupeConsignes(?GroupeConsignes $groupeConsignes): static
    {
        $this->groupeConsignes = $groupeConsignes;

        return $this;
    }

    public function __toString()
    {
        return "Libelle " . $this->libelle;
    }
}
