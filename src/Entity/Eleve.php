<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use dump\Famille;
use IntlDateFormatter;

#[ORM\Entity(repositoryClass: EleveRepository::class)]
class Eleve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;


    #[ORM\Column(length: 1, nullable: true)]
    private ?string $genre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $anniversaire = null;

    #[ORM\Column]
    private ?bool $droitImage = null;


    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?Classe $classe = null;

    #[ORM\OneToMany(mappedBy: 'eleve', targetEntity: FeuilleRoute::class, cascade:["persist"], orphanRemoval: true)]
    private Collection $feuilleRoutes;


    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'eleves')]
    private Collection $parents;

    #[ORM\OneToMany(mappedBy: 'eleve', targetEntity: Bulletin::class, cascade:["persist"], orphanRemoval: true)]
    private Collection $bulletins;

    #[ORM\OneToMany(mappedBy: 'eleve', targetEntity: Image::class, cascade:["persist"], orphanRemoval: true)]
    private Collection $images;

    #[ORM\Column(nullable: true)]
    private ?bool $besoin = null;

    public function __construct()
    {
        $this->feuilleRoutes = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->bulletins = new ArrayCollection();
        $this->images = new ArrayCollection();
    }


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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getGenre(): ?string
    {
        $genre = '';

        if($this->genre == 1){
            $genre = 'garçon';
        } else if($this->genre == 2){
            $genre = 'fille';
        } else {
            $genre = 'non renseigné';
        }
        return $genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAnniversaire(): ?\DateTimeInterface
    {
        return $this->anniversaire;
    }

    public function setAnniversaire(?\DateTimeInterface $anniversaire): self
    {
        $this->anniversaire = $anniversaire;

        return $this;
    }

    public function isDroitImage(): ?bool
    {
        return $this->droitImage;
    }

    public function getDroitImage(): ?string
    {
        $droitImageString = '';

        if($this->droitImage === false){
            $droitImageString  = 'non';
        } else if($this->droitImage === true){
            $droitImageString  = 'oui';
        } else {
            $droitImageString  = 'non renseigné';
        }
        
        return $droitImageString;
    }

    public function setDroitImage(bool $droitImage): self
    {
        $this->droitImage = $droitImage;

        return $this;
    }

    public function isBesoin(): ?bool
    {
        return $this->besoin;
    }

    public function setBesoin(?bool $besoin): self
    {
        $this->besoin = $besoin;

        return $this;
    }


    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * @return Collection<int, FeuilleRoute>
     */
    public function getFeuilleRoutes(): Collection
    {
        return $this->feuilleRoutes;
    }

    public function addFeuilleRoute(FeuilleRoute $feuilleRoute): self
    {
        if (!$this->feuilleRoutes->contains($feuilleRoute)) {
            $this->feuilleRoutes->add($feuilleRoute);
            $feuilleRoute->setEleve($this);
        }

        return $this;
    }

    public function removeFeuilleRoute(FeuilleRoute $feuilleRoute): self
    {
        if ($this->feuilleRoutes->removeElement($feuilleRoute)) {
            // set the owning side to null (unless already changed)
            if ($feuilleRoute->getEleve() === $this) {
                $feuilleRoute->setEleve(null);
            }
        }

        return $this;
    }

    public function getJourAnnivEleve()
    {
        date_default_timezone_set('Europe/Paris');
        //je recupére mes objet datetime
        $date = $this->anniversaire;

        //je formate mes objetS
    

        date_default_timezone_set('Europe/Moscow');//Moscou = GMT+3

        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::NONE, IntlDateFormatter::NONE);
        $formatter->setPattern('EEEE, d MMMM');

        $jourAnnivEleve = $formatter->format($date);

        return $jourAnnivEleve;
    }


    /**
     * @return Collection<int, User>
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(User $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents->add($parent);
        }

        return $this;
    }

    public function removeParent(User $parent): self
    {
        $this->parents->removeElement($parent);

        return $this;
    }

    /**
     * @return Collection<int, Bulletin>
     */
    public function getBulletins(): Collection
    {
        return $this->bulletins;
    }

    public function addBulletin(Bulletin $bulletin): self
    {
        if (!$this->bulletins->contains($bulletin)) {
            $this->bulletins->add($bulletin);
            $bulletin->setEleve($this);
        }

        return $this;
    }

    public function removeBulletin(Bulletin $bulletin): self
    {
        if ($this->bulletins->removeElement($bulletin)) {
            // set the owning side to null (unless already changed)
            if ($bulletin->getEleve() === $this) {
                $bulletin->setEleve(null);
            }
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
            $image->setEleve($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getEleve() === $this) {
                $image->setEleve(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->prenom . " " . $this->nom;
    }


}
