<?php

namespace App\Entity;

use App\Repository\FeuilleRouteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use IntlDateFormatter;

#[ORM\Entity(repositoryClass: FeuilleRouteRepository::class)]
class FeuilleRoute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(nullable: true)]
    private ?int $semaine = null;

    #[ORM\Column]
    private ?bool $validation;

    #[ORM\ManyToOne(inversedBy: 'feuilleRoutes')]
    private ?Eleve $eleve = null;

    #[ORM\ManyToMany(targetEntity: Activite::class, mappedBy: 'feuillesroute')]
    private Collection $activites;

    #[ORM\OneToMany(mappedBy: 'feuille_route', targetEntity: Image::class, cascade:["persist"], orphanRemoval: true)]
    private Collection $images;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
        $this->images = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDates()
    {
        date_default_timezone_set('Europe/Paris');
        //je recupére mes objet datetime
        $dateDebut =  $this->dateDebut;
        $dateFin =  $this->dateFin;

        //je formate mes objetS


        date_default_timezone_set('Europe/Moscow');//Moscou = GMT+3

        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::NONE, IntlDateFormatter::NONE);
        $formatter->setPattern('EEEE, d MMMM');

        $dateDebutString = $formatter->format($dateDebut);
        $dateFinString = $formatter->format($dateFin);

        return $dateDebutString . " - " . $dateFinString;
    }

    public function getSemaine(): ?int
    {
        return $this->semaine;
    }

    public function setSemaine(?int $semaine): self
    {
        $this->semaine = $semaine;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(bool $validation): self
    {
        $this->validation = $validation;
        return $this;
    }


    public function afficheValidation(): ?string
    {
        if ($this->validation === true){
            return 'oui';
        }
        return 'non';
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
            $activite->addFeuillesroute($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            $activite->removeFeuillesroute($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setFeuilleRoute($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getFeuilleRoute() === $this) {
                $image->setFeuilleRoute(null);
            }
        }

        return $this;
    }
    /*
     * To string
     * */
    public function __toString(){
        return "feuille de route de " . $this->getEleve();
    }

}
