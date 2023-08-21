<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActiviteRepository::class)]
class Activite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?bool $validation = null;

    #[ORM\ManyToOne(inversedBy: 'activites')]
    private ?GroupeConsignes $groupeconsignes = null;

    #[ORM\ManyToMany(targetEntity: FeuilleRoute::class, inversedBy: 'activites')]
    private Collection $feuillesroute;

    #[ORM\ManyToMany(targetEntity: GroupeCompetences::class, inversedBy: 'activites')]
    private Collection $groupescompetences;

    public function __construct()
    {
        $this->feuillesroute = new ArrayCollection();
        $this->groupescompetences = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getGroupeconsignes(): ?GroupeConsignes
    {
        return $this->groupeconsignes;
    }

    public function setGroupeconsignes(?GroupeConsignes $groupeconsignes): self
    {
        $this->groupeconsignes = $groupeconsignes;

        return $this;
    }

    /**
     * @return Collection<int, FeuilleRoute>
     */
    public function getFeuillesroute(): Collection
    {
        return $this->feuillesroute;
    }

    public function addFeuillesroute(FeuilleRoute $feuillesroute): self
    {
        if (!$this->feuillesroute->contains($feuillesroute)) {
            $this->feuillesroute->add($feuillesroute);
        }

        return $this;
    }

    public function removeFeuillesroute(FeuilleRoute $feuillesroute): self
    {
        $this->feuillesroute->removeElement($feuillesroute);

        return $this;
    }

    /**
     * @return Collection<int, GroupeCompetences>
     */
    public function getGroupescompetences(): Collection
    {
        return $this->groupescompetences;
    }

    public function addGroupescompetence(GroupeCompetences $groupescompetence): self
    {
        if (!$this->groupescompetences->contains($groupescompetence)) {
            $this->groupescompetences->add($groupescompetence);
        }

        return $this;
    }

    public function removeGroupescompetence(GroupeCompetences $groupescompetence): self
    {
        $this->groupescompetences->removeElement($groupescompetence);

        return $this;
    }

    public function __toString(){
        return $this->titre;
    }
}
