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

    #[ORM\ManyToMany(targetEntity: Eleve::class, inversedBy: 'bulletins')]
    private Collection $eleve;

    #[ORM\ManyToOne(inversedBy: 'relation')]
    private ?Trimestre $trimestre = null;

    public function __construct()
    {
        $this->eleve = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        return "bulletin". $this->eleve;
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
}
