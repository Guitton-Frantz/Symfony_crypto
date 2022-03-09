<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $com;

    /**
     * @ORM\OneToMany(targetEntity=Cryptomonnaie::class, mappedBy="commentaire")
     */
    private $cryptomonnaie;

    public function __construct()
    {
        $this->cryptomonnaie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCom(): ?string
    {
        return $this->com;
    }

    public function setCom(string $com): self
    {
        $this->com = $com;

        return $this;
    }

    /**
     * @return Collection<int, Cryptomonnaie>
     */
    public function getCryptomonnaie(): Collection
    {
        return $this->cryptomonnaie;
    }

    public function addCryptomonnaie(Cryptomonnaie $cryptomonnaie): self
    {
        if (!$this->cryptomonnaie->contains($cryptomonnaie)) {
            $this->cryptomonnaie[] = $cryptomonnaie;
            $cryptomonnaie->setCommentaire($this);
        }

        return $this;
    }

    public function removeCryptomonnaie(Cryptomonnaie $cryptomonnaie): self
    {
        if ($this->cryptomonnaie->removeElement($cryptomonnaie)) {
            // set the owning side to null (unless already changed)
            if ($cryptomonnaie->getCommentaire() === $this) {
                $cryptomonnaie->setCommentaire(null);
            }
        }

        return $this;
    }
}
