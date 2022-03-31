<?php

namespace App\Entity;

use App\Repository\CryptomonnaieRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Commentaire;
use App\Entity\Note;


/**
 * @ORM\Entity(repositoryClass=CryptomonnaieRepository::class)
 */
class Cryptomonnaie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $MarketCap;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $projet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorie;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreation;

    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="favoris")
     */
    private $fans;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="cryptomonnaie")
     */
    private $commentaire;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="crypto")
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cryptosCreated")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;




    public function __construct()
    {
        $this->fans = new ArrayCollection();
        $this->commentaire = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarketCap(): ?int
    {
        return $this->MarketCap;
    }

    public function setMarketCap(int $MarketCap): self
    {
        $this->MarketCap = $MarketCap;

        return $this;
    }

    public function getProjet(): ?string
    {
        return $this->projet;
    }

    public function setProjet(string $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDateCreation(): ?DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

   

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFans(): Collection
    {
        return $this->fans;
    }

    public function addFan(User $fan): self
    {
        if (!$this->fans->contains($fan)) {
            $this->fans[] = $fan;
            $fan->addFavori($this);
        }

        return $this;
    }

    public function removeFan(User $fan): self
    {
        if ($this->fans->removeElement($fan)) {
            $fan->removeFavori($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire[] = $commentaire;
            $commentaire->setCryptomonnaie($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getCryptomonnaie() === $this) {
                $commentaire->setCryptomonnaie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setCrypto($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getCrypto() === $this) {
                $note->setCrypto(null);
            }
        }

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

   
}
