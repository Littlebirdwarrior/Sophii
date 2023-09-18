<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use dump\Enseignant;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Eleve::class)]
    private Collection $eleves;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    private ?Niveau $niveau = null;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: User::class)]
    private Collection $enseignants;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
        $this->enseignants = new ArrayCollection();
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

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection<int, Eleve>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function countEleves(): int
    {
        return count($this->eleves);
    }

    public function addElefe(Eleve $elefe): self
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves->add($elefe);
            $elefe->setClasse($this);
        }

        return $this;
    }

    public function removeElefe(Eleve $elefe): self
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getClasse() === $this) {
                $elefe->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getEnseignants(): Collection
    {
        return $this->enseignants;
    }

    public function getNomEnseignants(): string
    {
        $listNoms = " ";
        $tabEns = $this->enseignants;
        if (!empty($tabEns)) {
            foreach ($tabEns as $ens) {
                $listNoms .= $ens->getPrenom() . " " .$ens->getNom();
                while (count($tabEns) > 1) {
                    $listNoms .= " et ";
                }
            }
        } else {
            $listNoms = "pas encore d'enseignants";
        }

        return $listNoms;

    }

    public function addEnseignant(User $enseignant): self
    {
        if (!$this->enseignants->contains($enseignant)) {
            $this->enseignants->add($enseignant);
            $enseignant->setClasse($this);
        }

        return $this;
    }

    public function removeEnseignant(User $enseignant): self
    {
        if ($this->enseignants->removeElement($enseignant)) {
            // set the owning side to null (unless already changed)
            if ($enseignant->getClasse() === $this) {
                $enseignant->setClasse(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return "Classe de " . $this->libelle . " (" . $this->niveau . ")";
    }

}
