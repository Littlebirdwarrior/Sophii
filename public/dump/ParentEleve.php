<?php

namespace dump;

use App\Entity\Famille;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ParentEleveRepository::class)]
class ParentEleve
{

    #[ORM\Column]
    private ?bool $authorite = null;

    #[ORM\Column(length: 7)]
    private ?string $qualite = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $nomUsage = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 50)]
    private ?string $profession = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 10)]
    private ?string $cp = null;

    #[ORM\Column(length: 100)]
    private ?string $ville = null;

    #[ORM\ManyToOne(inversedBy: 'parentsEleve')]
    private ?Famille $famille = null;

    public function isAuthorite(): ?bool
    {
        return $this->authorite;
    }

    public function getAuthorite(): ?string
    {
        $authoriteString = '';

        if($this->authorite == 0){
            $authoriteString = 'oui';
        }else{
            $authoriteString = 'non';
        }

        return $authoriteString;
    }

    public function setAuthorite(bool $authorite): self
    {
        $this->authorite = $authorite;

        return $this;
    }

    public function getQualite(): ?string
    {
        return $this->qualite;
    }

    public function setQualite(string $qualite): self
    {
        $this->qualite = $qualite;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNomUsage(): ?string
    {
        return $this->nomUsage;
    }

    public function setNomUsage(string $nomUsage): self
    {
        $this->nomUsage = $nomUsage;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }


    public function getFamille(): ?Famille
    {
        return $this->famille;
    }

    public function setFamille(?Famille $famille): self
    {
        $this->famille = $famille;

        return $this;
    }

    public function __toString()
    {

        return $this->prenom . " " . $this->nom . "; parent de " . $this->getFamille()->getEnfantsList();
    }
}

// . "; parent de " . $ePrenom