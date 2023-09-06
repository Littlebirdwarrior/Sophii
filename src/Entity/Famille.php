<?php

namespace App\Entity;

use App\Repository\FamilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use dump\ParentEleve;

#[ORM\Entity(repositoryClass: FamilleRepository::class)]
class Famille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\OneToMany(mappedBy: 'famille', targetEntity: Eleve::class)]
    private Collection $eleves;

    #[ORM\OneToMany(mappedBy: 'famille', targetEntity: User::class)]
    private Collection $parents;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom = null;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
        $this->parents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Eleve>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function getEnfantsList()
    {
        $enfants = $this->getEleves();
        $listNom = [];
        $nomEnfant = "";

        foreach ($enfants as $enfant){
            $ePrenom = $enfant->getPrenom();
            $eNom = $enfant->getNom();

            $listNom[] = $ePrenom . " " . $eNom;
        }

        if(!empty($listNom)){
            foreach ($listNom as $nomEnfant){
                $nomEnfant .= "";
            }

            return $nomEnfant;
        }

         return "pas d'enfants enregistré";
    }

    public function addElefe(Eleve $elefe): self
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves->add($elefe);
            $elefe->setFamille($this);
        }

        // Ajouter le nom de l'élève à la famille
        $this->setNom($elefe->getNom());

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

    /**
     * @return Collection<int, User>
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(User $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents->add($parent);
            $parent->setFamille($this);
        }

        return $this;
    }

    public function removeParent(User $parent): self
    {
        if ($this->parents->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getFamille() === $this) {
                $parent->setFamille(null);
            }
        }

        return $this;
    }

    public function __toString(){

        return "famille " . $this->getNom() ;
    }

}




