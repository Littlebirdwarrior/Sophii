<?php

namespace App\Entity;

use App\Repository\GroupeCompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupeCompetencesRepository::class)]
class GroupeCompetences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;


    #[ORM\OneToMany(mappedBy: 'groupecompetences', targetEntity: Competence::class,
    cascade:["persist"], orphanRemoval: true)]
    private Collection $competences;

    #[ORM\ManyToMany(targetEntity: Activite::class, mappedBy: 'groupescompetences')]
    private Collection $activites;

    #[ORM\OneToMany(mappedBy: 'groupeCompetences', targetEntity: BulletinGroupeCompetences::class, orphanRemoval: true)]
    private Collection $bulletinGroupeCompetences;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->activites = new ArrayCollection();
        $this->bulletinGroupeCompetences = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return Collection<int, Competence>
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences->add($competence);
            $competence->setGroupecompetences($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getGroupecompetences() === $this) {
                $competence->setGroupecompetences(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Activite>
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites->add($activite);
            $activite->addGroupescompetence($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            $activite->removeGroupescompetence($this);
        }

        return $this;
    }
    
    /**
     * @return Collection<int, BulletinGroupeCompetences>
     */
    public function getBulletinGroupeCompetences(): Collection
    {
        return $this->bulletinGroupeCompetences;
    }

    public function addBulletinGroupeCompetence(BulletinGroupeCompetences $bulletinGroupeCompetence): self
    {
        if (!$this->bulletinGroupeCompetences->contains($bulletinGroupeCompetence)) {
            $this->bulletinGroupeCompetences->add($bulletinGroupeCompetence);
            $bulletinGroupeCompetence->setGroupeCompetences($this);
        }

        return $this;
    }

    public function removeBulletinGroupeCompetence(BulletinGroupeCompetences $bulletinGroupeCompetence): self
    {
        if ($this->bulletinGroupeCompetences->removeElement($bulletinGroupeCompetence)) {
            // set the owning side to null (unless already changed)
            if ($bulletinGroupeCompetence->getGroupeCompetences() === $this) {
                $bulletinGroupeCompetence->setGroupeCompetences(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->titre;
    }
}
