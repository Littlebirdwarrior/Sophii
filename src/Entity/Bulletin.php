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

    public function __construct()
    {
        $this->groupecompetences = new ArrayCollection();
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
}
