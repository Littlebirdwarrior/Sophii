<?php

namespace App\Entity;

use App\Repository\BulletinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BulletinRepository::class)]
class Bulletin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'relation')]
    private ?Trimestre $trimestre = null;

    #[ORM\OneToMany(mappedBy: 'bulletin', targetEntity: BulletinGroupeCompetences::class,
        cascade:["persist"], orphanRemoval: true)]
    private Collection $bulletinGroupeCompetences;

    #[ORM\ManyToOne(inversedBy: 'bulletins')]
    private ?Eleve $eleve = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function __construct()
    {
        $this->bulletinGroupeCompetences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrimestre(): ?Trimestre
    {
        return $this->trimestre;
    }

    public function setTrimestre(?Trimestre $trimestre): self
    {
        $this->trimestre = $trimestre;

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
            $bulletinGroupeCompetence->setBulletin($this);
        }

        return $this;
    }

    public function removeBulletinGroupeCompetence(BulletinGroupeCompetences $bulletinGroupeCompetence): self
    {
        if ($this->bulletinGroupeCompetences->removeElement($bulletinGroupeCompetence)) {
            // set the owning side to null (unless already changed)
            if ($bulletinGroupeCompetence->getBulletin() === $this) {
                $bulletinGroupeCompetence->setBulletin(null);
            }
        }

        return $this;
    }

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): self
    {
        $this->eleve = $eleve;

        return $this;
    }

    public function __toString(){
        return "bulletin ";
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
