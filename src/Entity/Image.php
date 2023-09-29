<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Symfony\Component\Validator\Constraint;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Eleve $eleve = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Activite $activite = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?FeuilleRoute $feuille_route = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): self
    {
        $this->eleve = $eleve;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getActivite(): ?Activite
    {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getFeuilleRoute(): ?FeuilleRoute
    {
        return $this->feuille_route;
    }

    public function setFeuilleRoute(?FeuilleRoute $feuille_route): self
    {
        $this->feuille_route = $feuille_route;

        return $this;
    }
}
