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

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Eleve::class)]
    private Collection $eleves;


    #[ORM\ManyToOne(inversedBy: 'classes')]
    private ?Niveau $niveau = null;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Enseignant>

    public function getEnseignant(): Collection
    {
        return $this->enseignant;
    }

    public function getlistIdEnseignant(): array
    {
        $listIdEns = [];
        if(count($this->enseignant) > 1){
            foreach ($this->enseignant as $e){
                $listIdEns[] = $e->getId();
            }
        }
        return $listIdEns;
    }

    public function getlistNomEnseignant(): String
    {
        $eNom = "";
        foreach ($this->enseignant as $e){
            $eNom .= $e->getPrenom() . " " . $e->getNom();
        }

        if(count($this->enseignant) > 1){
            foreach ($this->enseignant as $e){
                $eNom .= $e->getPrenom() . " " . $e->getNom() . " - ";
            }
        }
        
        return $eNom;
    }


    public function addEnseignant(Enseignant $enseignant): self
    {
        if (!$this->enseignant->contains($enseignant)) {
            $this->enseignant->add($enseignant);
            $enseignant->setClasse($this);
        }

        return $this;
    }

    public function removeEnseignant(Enseignant $enseignant): self
    {
        if ($this->enseignant->removeElement($enseignant)) {
            // set the owning side to null (unless already changed)
            if ($enseignant->getClasse() === $this) {
                $enseignant->setClasse(null);
            }
        }

        return $this;
    } */

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    
    public function __toString()
    {
       /* foreach ($this->enseignant as $e){
            $eNom = $e->getNom();
        }*/

        return "Classe de " . $this->niveau /*" (" . $this->getlistNomEnseignant() . ")"*/;
    }

}
