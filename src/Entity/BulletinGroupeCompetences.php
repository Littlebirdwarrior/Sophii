<?php

namespace App\Entity;

use App\Repository\BulletinGroupeCompetencesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\FormTypeInterface;

#[ORM\Entity(repositoryClass: BulletinGroupeCompetencesRepository::class)]
class BulletinGroupeCompetences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $acquisition = null;

    #[ORM\ManyToOne(inversedBy: 'bulletinGroupeCompetences')]
    private ?Bulletin $bulletin = null;

    #[ORM\ManyToOne(inversedBy: 'bulletinGroupeCompetences')]
    private ?GroupeCompetences $groupe_competence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAcquisition(): ?bool
    {
        return $this->acquisition;
    }

    public function setAcquisition(?bool $acquisition): self
    {
        $this->acquisition = $acquisition;

        return $this;
    }

    public function getBulletin(): ?Bulletin
    {
        return $this->bulletin;
    }

    public function setBulletin(?Bulletin $bulletin): self
    {
        $this->bulletin = $bulletin;

        return $this;
    }

    public function getGroupeCompetence(): ?GroupeCompetences
    {
        return $this->groupe_competence;
    }

    public function setGroupeCompetence(?GroupeCompetences $groupe_competence): self
    {
        $this->groupe_competence = $groupe_competence;

        return $this;
    }
}
