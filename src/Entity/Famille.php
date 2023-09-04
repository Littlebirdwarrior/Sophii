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

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
        $this->parents = new ArrayCollection();
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

    public function getNomFamille()
    {
        $enfants = $this->getEleves();
        $listNoms = [];
        $nomFamille = "";
        $eNom = "";

        foreach ($enfants as $enfant){
            $eNom = $enfant->getNom();

            if(!(in_array($eNom, $listNoms))){
                $listNoms[] = $eNom;
            }
            
        }
        if(!empty($listNoms)){
            foreach ($listNoms as $nomFamille){
                $nomFamille .= "";
                return $nomFamille;
            }

        }

        return "non renseigné";
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

        return "famille " . $this->getNomFamille(); // /*. " ont pour pour enfant(s) " . $this->getEnfantsList()*/
    }

    /*

    public function getParentsEleve(): Collection
    {
    return $this->parentsEleve;
    }

    public function getParentsList()
    {
    $parents = $this->getParentsEleve();
    $listNom = [];
    $nomParent = "";

    foreach ($parents as $parent){
    $pPrenom = $parent->getPrenom();
    $pNom = $parent->getNom();

    $listNom[] = $pPrenom . " " . $pNom;
    }

    foreach ($listNom as $nomParent){
    $nomParent .= "";
    }

    return $nomParent;
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
    } */

}