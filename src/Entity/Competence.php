<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(nullable: true, options: ["default" => false])]
    private ?bool $acquisition = null;

    #[ORM\ManyToOne(inversedBy: 'competences')]
    private ?GroupeCompetences $groupecompetences = null;

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

    public function isAcquisition(): ?bool
    {
        return $this->acquisition;
    }

    public function getAcquisition(): ?string
    {
        if($this->acquisition === true){
          return "oui";
        } else {
            return "non";
        }
    }

    public function setAcquisition(bool $acquisition): self
    {
        $this->acquisition = $acquisition;

        return $this;
    }

    public function getGroupecompetences(): ?GroupeCompetences
    {
        return $this->groupecompetences;
    }

    public function setGroupecompetences(?GroupeCompetences $groupecompetences): self
    {
        $this->groupecompetences = $groupecompetences;

        return $this;
    }

    public function __toString()
    {
        //."(Groupe : ". $this->groupecompetences .")"
        return "Libelle " . $this->libelle ;
    }
}
