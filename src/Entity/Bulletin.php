<?php

namespace App\Entity;

use App\Repository\BulletinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BulletinRepository::class)]
class Bulletin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $trimeste = null;

    #[ORM\ManyToMany(targetEntity: GroupeCompetences::class, inversedBy: 'bulletins')]
    private Collection $groupecompetences;

    #[ORM\ManyToOne(inversedBy: 'bulletins')]
    private ?Niveau $niveau = null;

    #[ORM\ManyToMany(targetEntity: Eleve::class, inversedBy: 'bulletins')]
    private Collection $eleve;

    public function __construct()
    {
        $this->groupecompetences = new ArrayCollection();
        $this->eleve = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrimeste(): ?int
    {
        return $this->trimeste;
    }

    public function setTrimeste(int $trimeste): self
    {
        $this->trimeste = $trimeste;

        return $this;
    }

    /**
     * @return Collection<int, GroupeCompetences>
     */
    public function getGroupecompetences(): Collection
    {
        return $this->groupecompetences;
    }

    public function addGroupecompetence(GroupeCompetences $groupecompetence): self
    {
        if (!$this->groupecompetences->contains($groupecompetence)) {
            $this->groupecompetences->add($groupecompetence);
        }

        return $this;
    }

    public function removeGroupecompetence(GroupeCompetences $groupecompetence): self
    {
        $this->groupecompetences->removeElement($groupecompetence);

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
    public function getEleve(): Collection
    {
        return $this->eleve;
    }

    public function addEleve(Eleve $eleve): self
    {
        if (!$this->eleve->contains($eleve)) {
            $this->eleve->add($eleve);
        }

        return $this;
    }

    public function removeEleve(Eleve $eleve): self
    {
        $this->eleve->removeElement($eleve);

        return $this;
    }

    public function __toString(){
        return "bulletin";
    }
}
