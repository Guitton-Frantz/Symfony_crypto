<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Cryptomonnaie;
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
     * @ORM\ManyToOne(targetEntity=Cryptomonnaie::class, inversedBy="commentaire")
     */
    private $cryptomonnaie;

    

    

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

    public function getCryptomonnaie(): ?Cryptomonnaie
    {
        return $this->cryptomonnaie;
    }

    public function setCryptomonnaie(?Cryptomonnaie $cryptomonnaie): self
    {
        $this->cryptomonnaie = $cryptomonnaie;

        return $this;
    }

   
}
