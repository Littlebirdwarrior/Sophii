<?php

namespace App\Entity;

use App\Repository\BulletinRepository;
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
}
