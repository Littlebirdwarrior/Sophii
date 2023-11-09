<?php

namespace App\Entity;

use App\Repository\BulletinGroupeCompetencesRepository;
use Doctrine\ORM\Mapping as ORM;

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
    #[ORM\JoinColumn(onDelete: 'cascade')]
    private ?Bulletin $bulletin = null;

    #[ORM\ManyToOne(inversedBy: 'bulletinGroupeCompetences')]
    #[ORM\JoinColumn(onDelete: 'cascade')]
    private ?GroupeCompetences $groupeCompetences = null;


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

    public function getGroupeCompetences(): ?GroupeCompetences
    {
        return $this->groupeCompetences;
    }

    public function setGroupeCompetences(?GroupeCompetences $groupeCompetences): self
    {
        $this->groupeCompetences = $groupeCompetences;

        return $this;
    }

    public function toString(): ?string
    {
        return "groupe de compétence numéro". $this->id;
    }
}
